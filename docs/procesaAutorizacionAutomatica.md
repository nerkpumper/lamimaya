# Reglas de Autorización Automática de Pedidos

## Método
`ModeloPedido::procesaAutorizacionAutomatica($idPedido, $simulacion = false)`

**Archivo:** `include/model/extend/model.pedido.inc.php:2912`

## Flujo General

```
Entrada: idPedido en estado CAPTURADO
    │
    ├─ 1. Verificar si necesita surtir materiales
    ├─ 2. Obtener datos financieros del cliente (crédito, capacidad de pago, días vencido)
    └─ 3. Aplicar reglas de autorización
         │
         ├─ ¿Cliente existe? (idCliente > 0)
         │   ├─ Sí → ¿Tiene crédito? (credito > 0)
         │   │   ├─ Sí → Reglas CON crédito (A)
         │   │   └─ No → Reglas SIN crédito (B)
         │   └─ No → Error (no se puede autorizar)
         │
         └─ Resultado: AUTORIZADO (automático) o requiere revisión manual
```

---

## Paso 1 — Verificar si surte o no

Se ejecuta `verificarSiPedidoPuedeSurtirse()`.
- Si la lista `NoSurtir` tiene elementos → **necesitaSurtir = true**
- Caso contrario → **necesitaSurtir = false**

Esto indica si el pedido requiere adquisición de materia prima (rollos para fabricar) o si ya hay inventario suficiente.

---

## Paso 2 — Obtener datos financieros

### Origen de datos

| Condición | Origen |
|-----------|--------|
| `idClienteDatosFacturacion == 0` o `Privado == 'SI'` | Tabla `cliente` directamente |
| Otro caso | Tabla `clientedatosfacturacion` + `datosfacturacion` (por RFC) |

### Variables obtenidas

| Variable | Descripción |
|----------|-------------|
| `credito` | Límite de crédito del cliente |
| `capacidadPago` | Capacidad de pago |
| `creditoUsado` | Crédito actualmente usado |
| `creditoUsadoEntregados` | Crédito usado solo en pedidos **entregados** |
| `diasVencido` | Días de vencido más antiguos |
| `saldomas30dias` | Saldo vencido > 30 días |
| `noPedidosCliente` | Número de pedidos del cliente (1 = cliente nuevo) |

### Variables calculadas

| Variable | Fórmula |
|----------|---------|
| `creditoDisponible` | `credito - creditoUsado` |
| `creditoDisponibleEntregados` | `credito - creditoUsadoEntregados` |
| `capacidadPagoDisponible` | `capacidadPago - creditoUsado` |
| `capacidadPagoDisponibleEntregados` | `capacidadPago - creditoUsadoEntregados` |
| `pagado` | `total - saldo` |
| `saldoPedido` | `saldo` |
| `porcentaje` | `(pagado / total) × 100` |
| `clienteNuevo` | `noPedidosCliente == 1` |

---

## Paso 3 — Reglas de Autorización

### A. Cliente CON Crédito (`credito > 0`)

```
┌─ ¿Necesita surtir?
│   ├─ SÍ → ❌ REQUIERE AUTORIZACIÓN MANUAL
│   │         Se necesita adquirir rollos/materia prima.
│   │         Crédito y Cobranza debe liberar manualmente.
│   │
│   └─ NO  → ¿CreditoDisponibleEntregados >= SaldoPedido 
│              Y DiasVencido < 30?
│              ├─ SÍ → ✅ AUTORIZACIÓN AUTOMÁTICA
│              │        "Saldo de crédito cubre pedido 
│              │         y no tiene vencidos > 30 días"
│              │
│              └─ NO  → ❌ MANUAL, con sub-reglas:
│                         
│                        ¿DiasVencido < 5 Y 
│                         CreditoDisponibleEntregados > SaldoPedido?
│                        ├─ SÍ → Liberación manual por CxC
│                        │       (pedidos con hasta 5 días vencido,
│                        │        se avisa al promotor)
│                        │
│                        └─ NO  → ¿DiasVencido < 16 Y 
│                                   CreditoDisponibleEntregados > SaldoPedido?
│                                   ├─ SÍ → Liberación manual por CxC
│                                   │       (facturas < 15 días vencido,
│                                   │        requiere promesa de pago ≤ 1 semana)
│                                   │
│                                   └─ NO  → Liberación manual por CxC
│                                            (> 15 días vencido,
│                                             requiere pago confirmado,
│                                             80% liberado para materiales)
```

#### Eventos de Tracking (RazonAutorizacion)

| Código | Evento |
|--------|--------|
| 1 | Inicia proceso de autorización automática |
| 2 | Cliente con crédito, necesita surtir: requiere revisión manual |
| 7 | Cliente con crédito, no necesita surtir |
| 70 | **SUCCESS**: Autorización automática por crédito disponible y sin vencidos > 30 días |
| 71 | **WARNING**: Crédito disponible no cubre saldo o tiene vencidos > 30 días |
| 72 | **ERROR**: Manual por CxC — vencido < 5 días, crédito sí cubre |
| 73 | **ERROR**: Manual por CxC — vencido < 16 días, crédito sí cubre, requiere promesa de pago |
| 74 | **ERROR**: Manual por CxC — vencido > 15 días, requiere pago confirmado |

---

### B. Cliente SIN Crédito (`credito == 0`)

```
┌─ ¿Necesita surtir?
│   ├─ SÍ → ❌ REQUIERE AUTORIZACIÓN MANUAL
│   │         Sin crédito y necesita materiales.
│   │
│   └─ NO  → ¿Porcentaje == 100?
│              ├─ SÍ → ✅ AUTORIZACIÓN AUTOMÁTICA
│              │        "Pedido pagado en su totalidad"
│              │
│              └─ NO  → ¿DiasVencido < 8 Y 
│                        CapacidadPagoDisponibleEntregados > SaldoPedido?
│                        ├─ SÍ → ✅ AUTORIZACIÓN AUTOMÁTICA
│                        │        "Capacidad de pago cubre el valor
│                        │         y no tiene vencidos > 7 días"
│                        │
│                        └─ NO  → ❌ MANUAL, con sub-reglas:
│                                   
│                                   ¿Porcentaje >= 50?
│                                   ├─ SÍ → Liberación manual por CxC
│                                   │       (abono ≥ 50%, vale de salida 
│                                   │        bloqueado hasta liquidación)
│                                   │
│                                   └─ NO  → Liberación manual por CxC
│                                            (caso fuera de regla,
│                                             a criterio, evaluando
│                                             importancia y comportamiento
│                                             del cliente)
```

#### Eventos de Tracking

| Código | Evento |
|--------|--------|
| 16 | **WARNING**: Cliente sin crédito, necesita surtir |
| 24 | Cliente sin crédito, no necesita surtir |
| 76 | **SUCCESS**: Autorización automática — pago total (100%) |
| 77 | **SUCCESS**: Autorización automática — capacidad de pago cubre saldo y sin vencidos > 7 días |
| 78 | **WARNING**: Capacidad de pago NO cubre saldo o tiene vencidos > 7 días |
| 79 | **ERROR**: Manual por CxC — abono ≥ 50% |
| 80 | **ERROR**: Manual por CxC — caso fuera de regla, a criterio |

---

## C. Error General

Si `idCliente == 0` (no se pudo obtener información del cliente):
- ❌ **No se puede procesar**
- Se registra evento de error (código 40)
- Se envía notificación al cliente: *"No se pudo obtener la información del cliente del pedido"*

---

## Resumen Visual

```
                     ┌────────────────────────────────────────────┐
                     │          Pedido en CAPTURADO              │
                     └────────────────────────────────────────────┘
                                        │
                                        ▼
                     ┌────────────────────────────────────────────┐
                     │      ¿Se pudo obtener info del cliente?   │
                     └────────────────────────────────────────────┘
                      ┌─── Sí ───┐                     ┌── No ─┐
                      ▼                                  ❌ Error
           ┌─────────────────────┐
           │   ¿Tiene crédito?   │
           └─────────────────────┘
           ┌── Sí (A) ──┐              ┌── No (B) ──┐
           ▼                            ▼
    ┌──────────────┐             ┌──────────────┐
    │¿Necesita     │             │¿Necesita     │
    │surtir?       │             │surtir?       │
    └──────┬───────┘             └──────┬───────┘
      Sí  │  No                    Sí  │  No
      ▼    ▼                         ▼    ▼
    ❌   ┌─────────────┐           ❌  ┌─────────────────┐
    Manual│CreditDisp >= │          Manual│%Pagado == 100? │
         │SaldoPedido   │               └────────┬────────┘
         │Y DiasVen <30?│                   Sí   │   No
         └──────┬───────┘                   ✅    ▼
            Sí  │   No                    ┌──────────────────┐
            ✅   ▼                        │Capacidad >=      │
                ┌──────────────────┐       │Saldo Y DiasVen<8?│
                │Sub-reglas manual │       └────────┬─────────┘
                │según días vencido│            Sí   │   No
                └──────────────────┘            ✅    ▼
                                                   ┌──────────────┐
                                                   │Sub-reglas    │
                                                   │manual según  │
                                                   │% pagado      │
                                                   └──────────────┘

✅ = Autorización Automática (setEstadoAUTORIZADO + tipo AUTOMATICO)
❌  = Requiere intervención manual de Crédito y Cobranza
```

## Autorización Automática — Campos que se setean

| Campo | Valor |
|-------|-------|
| `estado` | `AUTORIZADO` |
| `tipoAutorizacion` | `AUTOMATICO` |
| `fecha_autorizado` | Fecha/hora actual |
| `id_usuario_autorizado` | `2` (usuario sistema) |
| `observacionAutoriza` | Mensaje descriptivo del criterio aprobado |
