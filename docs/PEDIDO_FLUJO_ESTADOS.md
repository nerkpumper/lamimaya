# Flujo de Estados de Pedido / PedidoDetalle

Documentación del ciclo de vida del `pedido` y su `pedidodetalle`: **dónde** ocurre cada
cambio de estado (archivo, líneas aproximadas y pantalla), **de qué estado a cuál**, **qué
hace** y **qué otras tablas toca**.

Orden documentado = orden de flujo real:

```
                 (alta)
                   │
                   ▼
   ┌──────────┐  autorizar   ┌────────────┐  producir  ┌─────────────┐
   │CAPTURADO │─────────────▶│ AUTORIZADO │───────────▶│ PRODUCCION  │
   └────┬─────┘              └─────┬──────┘            └──────┬──────┘
        │                          │                          │ surtir
        │ cancelar                 │ cancelar                 ▼
        │                          │                    ┌─────────────┐
        ▼                          ▼                    │  TERMINADO  │
   ┌───────────────────────────────────────┐            └──────┬──────┘
   │              CANCELADO                 │                   │ vale salida
   └───────────────────────────────────────┘                   ▼
                                                         ┌─────────────┐
                                                         │   ENRUTA*   │
                                                         └──────┬──────┘
                                                                │ vale entregado
                                                                ▼
                                                         ┌─────────────┐
                                                         │  ENTREGADO  │
                                                         └─────────────┘
```

> \* **ENRUTA no se escribe en `pedido.estado`**. El pedido se queda en `TERMINADO` y el
> sub-estado de ruta se lleva en `pedido.tipoRuta = 'ENRUTA'`. Ver sección
> [TERMINADO → ENRUTA](#terminado--enruta-sub-estado-de-ruta).

---

## 1. Fuente de verdad y convenciones

- **Esquema**: `SQL/lamimaya_first.sql`.
- **Triggers**: la **base de datos viva** (`mayamaria`) puede diferir del dump. Consultar con:

  ```sh
  docker exec lamimaya-db-1 mysql -uroot -pmayaroot123 mayamaria -B -e \
    "SELECT TRIGGER_NAME, ACTION_STATEMENT FROM information_schema.triggers \
     WHERE TRIGGER_SCHEMA='mayamaria' \G"
  ```
- **En la app** un cambio de estado se hace siempre con
  `$pedido->setEstadoXXX()` + `$pedido->Guardar()`. **No** hay `UPDATE pedido SET estado=...`
  en los controladores.
- **Ruteo de pantallas**: `html/index.php` resuelve el módulo `NOMBRE` como
  `html/views/NOMBRE.view.php` + `include/controler/NOMBRE.inc.php` + `html/js/system/NOMBRE.js`.
  Por lo tanto *view ↔ controlador ↔ JS comparten nombre*.
- **Crons**: hay dos tipos:
  - **Web** (`runcronXXX`): se disparan desde el menú (solo `rol_ROOT`) y su lógica vive en
    `html/views/runcronXXX.view.php`.
  - **CLI** (`include/cron/*.cron.php`): ejecutados por cron del sistema/cPanel; detectan
    consola con `isCONSOLE` y usan `include/cron/configinclude.cron.php`.

## 2. Tablas y columnas relevantes

### `pedido`
| Columna | Tipo / valores | Nota |
|---|---|---|
| `estado` | `enum('CAPTURADO','AUTORIZADO','PRODUCCION','TERMINADO','ENRUTA','ENTREGADO','CANCELADO')` def. `CAPTURADO` | `lamimaya_first.sql:1731`. `ENRUTA` **no se usa** aquí. |
| `tipoRuta` | `enum('SINRUTA','ENRUTA','REENRUTAR')` def. `SINRUTA` | `lamimaya_first.sql:1794`. Estado real de ruta. |
| `explotado`, `explotadook` | `SI/NO` | Cálculo de explosión. |
| `despachado`, `despieceTerminado` | `SI/NO` | Surtido. |
| `colocado`, `colocadoAutomatico` | `SI/NO` | Asignación a sucursales. |
| `saldo`, `saldopromotor`, `saldada` | numéricos / `SI/NO` | CxC (trigger `cxc_AFTER_INSERT`). |
| `id_usuario_*`, `fecha_*` (capturado, autorizado, terminado, entregado, cancelado, enruta…) | | Sellos de tiempo/usuario. |

### `pedidodetalle`
| Columna | Valores | Nota |
|---|---|---|
| `estado` | `enum(...,'CANCELADO')` def. `CAPTURADO` | `lamimaya_first.sql:532`. |
| `despachado` | `SI/NO` | Al completarse **todos**, el pedido pasa a `TERMINADO`. |
| `partida`, `partidadespachada` | numéricos | Cantidad surtida. |
| `explotadoReal`, `listo_para_producir` | | Surtido por explosión. |

### Otras
- `invzmov`, `invzmovrollo`, `invzmovnorollo` – movimientos de inventario.
- `pedidodetallecolocacion` – asignación de stock por sucursal (`cantidadSurtida`).
- `valesalida`, `valesalidadetalle`, `rutaenvio` – ruta/entrega.
- `movsapartado` – apartado/desapartado.
- `cxc`, `cxcpromotor` – cuentas por cobrar.
- `producto`, `rollo`, `inventariosucursal`, `invzstocknorollo` – existencias.

## 3. Setters base

- `include/model/base/model.base.pedido.inc.php:313-346` – `setEstado` / `setEstadoCAPTURADO`
  / `...AUTORIZADO` / `...PRODUCCION` / `...TERMINADO` / `...ENRUTA` / `...ENTREGADO`
  / `...CANCELADO`. Solo asignan `$this->estado`.
- `include/model/base/model.base.pedidodetalle.inc.php` – equivalentes para el detalle.
- `include/model/clsBasicCommon.inc.php:842` – `setDateAndUser($evento, $idUsuario = 2)`
  escribe el sello `fecha_<evento>` / `id_usuario_<evento>`.

> ⚠️ **Bug latente**: en `include/model/extend/model.pedido.inc.php:64-92` los métodos
> `setPedidoPRODUCCION()`, `setPedidoTERMINADO()`, `setPedidoENTREGADO()` y
> `setPedidoCANCELADO()` **todos llaman `setEstadoAUTORIZADO()`** (copy/paste). No se usan en
> los flujos reales (que invocan `setEstadoXXX()` directo), pero conviene corregirlos.

---

## 4. Transiciones (orden de flujo)

### (alta) → `CAPTURADO`

| Qué | Dónde |
|---|---|
| Estado inicial | `include/model/extend/model.pedido.inc.php:64` `setEstadoCAPTURADO()` |
| Alta (web/xajax) | `include/controler/pedidonuevo.inc.php:2081 levantarPedido()` (registrada en `:3132`); variantes `levantarPedidoV2` y `pedidonuevo2/3/4/…` |
| Alta (precios) | `include/controler/pedidoactualizaprecios.inc.php:2568 levantarPedido()` |
| Sello | `include/controler/pedidonuevo.inc.php:2254 setDateAndUser("capturado")` |
| Guardar | `include/controler/pedidonuevo.inc.php:~2503` |
| Pantallas | `html/views/pedidonuevo.view.php` (+2..8, fallamoldura, otroscargos), `pedidoactualizaprecios.view.php` |
| JS | `html/js/system/pedidonuevo*.js`, `pedidoactualizaprecios.js` (llaman `xajax_levantarPedido`) |

**Tablas tocadas**: `pedido`, `pedidodetalle` (+ `pedidodetallecolocacion`, `pedidostracking`).
Triggers: `pedido_BEFORE_INSERT`, `pedido_AFTER_INSERT` (`lamimaya_first.sql:1819`, actualiza
datos de `cliente`), `pedidodetalle_BEFORE/AFTER_INSERT`, `pedidostracking_BEFORE_INSERT`.

**Caso especial**: cliente MDM `idcliente = 137` (Moldura) puede **nacer AUTORIZADO**
(`include/controler/pedidonuevo.inc.php:2259-2267`, `model.pedido.inc.php:64-89`).

---

### `CAPTURADO` → `AUTORIZADO`

| Vía | Dónde | Notas |
|---|---|---|
| **Manual (pantalla Pedido)** | `include/controler/pedido.inc.php:682 autorizarPedido()` → `:702` | Guarda `CAPTURADO`; setea observación, `setTipoAutorizacionCXC`, notifica. Pantalla `html/views/pedido.view.php:159` (botón “Autorizar Pedido”), JS `html/js/system/pedido.js` |
| **Recibo de dinero (auto)** | `include/controler/pedidonuevo.inc.php:3529 pagarConReciboDinero` / `include/model/extend/model.pedido.inc.php:3952 pagarConReciboDinero()` → `:3978` | Pago autoriza el pedido |
| **Crédito cliente/promotor** | `include/controler/prodpedido.inc.php:103 autorizarXCreditoCliente()`→`:122`; `:147 autorizarXCreditoPromotor()`→`:169`. Igual en `include/controler/prompedpermitirvale.inc.php:168/212` | JS `prompedpermitirvale.js`, `prompedxauth.js` |
| **Colocar pedido** | `include/controler/colocarpedido.inc.php:660 reasignarPedido()` → `:690` | Re-dispara colocación (pantalla `html/views/colocarpedido.view.php`) |
| **Cotización → pedido** | `include/model/extend/model.cotizacion.inc.php:1617, 1774` | |
| **Promotores (facturar)** | `include/controler/promopedidoafacturar.inc.php:253`→`:273`; `pedidoafacturar.inc.php:243`→`:263` | |
| **Automática** | `include/model/extend/model.pedido.inc.php:2912 procesaAutorizacionAutomatica()` → `setEstadoAUTORIZADO` en `:3097, 3129, 3178, 3187`; también `:2187` | |
| **Cron web** | `html/views/runcronprocesapedidos.view.php` (módulo `runcronprocesapedidos`, `rol_ROOT`) y `runcronapartadosfix.view.php` | Recorre `WHERE checarAutorizacion='SI'` y llama `procesaAutorizacionAutomatica` |
| **Cron CLI** | `include/cron/procesapedidos.cron.php`, `include/cron/autorizaautomatico.cron.php`, `include/cron/procesacreditos.cron.php` | Equivalente en línea de comandos |

**Tablas tocadas**: `pedido` (`estado`, `fecha_autorizado`, `id_usuario_autorizado`,
`observacion_autoriza`, `tipoAutorizacionCXC`), `pedidodetalle`. Notificación:
`pushnotifica` / `pedidostracking`. Triggers CxC: ver `cxc_AFTER_INSERT`.

**Trigger `cxc_AFTER_INSERT`** (abono/cargo): ajusta `pedido.saldo`; si `saldo<=0` →
`pedido.saldada='SI', fecha_saldada=NOW()`; inserta en `cxcpromotor`; marca
`cliente.procesarCreditos='SI'` (alimenta la autorización automática). **No cambia `estado`.**

---

### `AUTORIZADO` → `PRODUCCION`

| Vía | Dónde |
|---|---|
| **Manual** | `include/controler/pedido.inc.php:773 producirPedido()` → `:795` (exige `getEstado()=="AUTORIZADO"`). Pantalla `html/views/pedido.view.php`, JS `html/js/system/pedido.js:111` |
| **Promotores** | `include/controler/promopedidofechacompromiso.inc.php:350`→`:372`; también `promopedidoaceptafacturar.js:47`, `promopedidoafacturar.js:82` invocan `xajax_producirPedido` |

**Qué hace**: marca el pedido como en producción (`setEstadoPRODUCCION` +
`setDateAndUser("produccion")`). Habilita el surtido/despacho.

**Tablas tocadas**: `pedido`.

---

### `PRODUCCION` → `TERMINADO`

Se llega por **dos caminos**:

#### A) Automático — al surtir todo el detalle
`include/model/extend/model.pedidodetalle.inc.php:73-115 AfterUpdate()`
- Dispara cuando un `pedidodetalle.despachado` pasa `NO → SI`.
- Si **todos** los detalles del pedido quedan `despachado='SI'` →
  `setDespachadoSI()` + `setEstadoTERMINADO()` + `setFecha_terminado` +
  `setId_usuario_terminado` + `Guardar()` +
  `NotificationManager::WA_EstatusPedido(..., "TERMINADO")`.

#### B) Manual
- `include/controler/pedido.inc.php:905 terminarPedido()` → `:925` (exige `PRODUCCION`).
  JS `html/js/system/pedido.js:133`, `pedidoobra.js:351`.
- `include/controler/promopedidofechacompromiso.inc.php:477` → `:497`.

#### Quién pone `pedidodetalle.despachado = 'SI'` (el surtido real)
| Archivo | Función / línea |
|---|---|
| `include/controler/despacharpedido.inc.php` | `darSalidaAInventario` `:394`→`:447`; `darSalidaARollo` `:626`; `marcarComoDespachado` `:718`→`:732`; `marcarMaquilaRealizada` `:757`→`:771`; `darSalidaAInventarioFromStockNoRollo` `:797`→`:862`; `...Scrap` `:905`→`:960`; `...LaminaYScrap` `:1000`→`:1073` (pantalla `html/views/despacharpedido.view.php`) |
| `include/cron/surtestock.cron.php` (CLI) | `:217`, `:387` |
| `include/controler/registroproduccion.inc.php` | `:652` (pantalla `registroproduccion.view.php`) |
| `include/controler/pedidoobra.inc.php` | `:163` (pantalla `pedidoobra.view.php`) |
| `include/controler/zdespacharpedido.inc.php` | `:443, 728, 767` — **huérfano** (no referenciado; duplicado de `despacharpedido`) |

**Cadena de inventario (clave)**:
1. El controlador crea un `invzmov` / `invzmovrollo` de tipo `movimiento='SALIDA'` con
   `idPedidoDetalle`.
2. Trigger **`invzmov_AFTER_INSERT`** (y `invzmovrollo_AFTER_INSERT`): si `movimiento='SALIDA'`
   y `idPedidoDetalle>0` → actualiza
   `pedidodetalle.explotadoReal`, `partidadespachada(+)`, `fecha_despachado`,
   `id_usuario_despachado`, `idSucursalDespachado`; y `pedidodetallecolocacion.cantidadSurtida`;
   y `producto.existencia`, `rollo.existencia`, `inventariosucursal.existencia`,
   `invzstocknorollo.existencia`.
3. El `UPDATE` sobre `pedidodetalle` dispara **`pedidodetalle_AFTER_UPDATE`** → inserta
   `movsapartado` (APARTADO/DESAPARTADO) cuando cambia `partidadespachada` (pedidos antiguos
   `idPedido<5867`). La rama `INSERT INTO valesalidadetalle` y los bloques TERMINADO/ENTREGADO
   están **comentados** en la BD viva.

**Tablas tocadas**: `pedido`, `pedidodetalle`, `invzmov`/`invzmovrollo`/`invzmovnorollo`,
`pedidodetallecolocacion`, `movsapartado`, `producto`, `rollo`, `inventariosucursal`,
`invzstocknorollo`, `pushnotifica`.

---

### `TERMINADO` → `ENRUTA` (sub-estado de ruta)

> **Importante**: `pedido.estado` **nunca** pasa a `'ENRUTA'`. No existe caller de
> `$pedido->setEstadoENRUTA()` en todo el repositorio. El paso a ruta se refleja en
> **`pedido.tipoRuta = 'ENRUTA'`**.

| Qué | Dónde |
|---|---|
| Asignar vehículo/ruta (web) | `include/controler/asignarruta.inc.php:609 asignarVehiculos()` → `:753 $valeSalida->setEstadoENRUTA()`. Pantalla `html/views/asignarruta.view.php` |
| Poner `pedido.tipoRuta='ENRUTA'` | **Trigger `valesalida_AFTER_UPDATE`**: al pasar un `valesalida` a `estado='SALIDA'` ejecuta `update pedido set tipoRuta='ENRUTA' where idpedido=NEW.idPedido and tipoRuta='SINRUTA'` (dump: `SQL/lamimaya_first.sql:4010`) |
| Estados de ruta en otros modelos | `valesalida.estado='ENRUTA'` (`model.base.valesalida.inc.php:127`), `rutaenvio.estado='ENRUTA'` (`model.base.rutaenvio.inc.php:106`) |

**Tablas tocadas**: `pedido.tipoRuta`, `valesalida`, `rutaenvio`, `valesalidadetalle`.

---

### `ENRUTA` → `ENTREGADO`

| Vía | Dónde |
|---|---|
| **Automática (trigger)** | `valesalida_AFTER_UPDATE`: cuando **todos** los `valesalida` del pedido están `ENTREGADO` **y** `pedido.estado='TERMINADO'` → `UPDATE pedido SET estado='ENTREGADO', fecha_entregado, id_usuario_entregado` + inserta `pushnotifica` |
| **Regreso de vehículo (web)** | `include/controler/asignarruta.inc.php:1274 regresoDeVehiculo()` → `:1377 $valeSalida->setEstadoENTREGADO()`. Pantalla `html/views/asignarruta.view.php` |
| **Manual** | `include/controler/pedido.inc.php:946 entregarPedido()` → `:966`; `:990 terminarYEntregarPedido()` → `:1013`. JS `pedido.js:155,177` |
| **Promotores** | `include/controler/promopedidofechacompromiso.inc.php:517`→`:537` y `:557`→`:580` |
| **App móvil (API)** | `html/api/pedido.api.php:398 setEstadoENTREGADO()` |

**Tablas tocadas**: `pedido` (`estado`, `fecha_entregado`, `id_usuario_entregado`),
`valesalida`, `pushnotifica`, `pedidostracking`.

---

### → `CANCELADO`

| Estado origen | Dónde |
|---|---|
| `CAPTURADO` | `include/controler/cancelarpedido.inc.php:242` (rama “cancelar simple”; setea `saldo=0`, `saldopromotor=0`, `observacion_cancela`) |
| `AUTORIZADO` | `include/controler/cancelarpedido.inc.php:442` (+ reverso de CxC/timbras) |
| Otros (con apartado real) | `include/controler/cancelarpedido.inc.php` maneja reversos de `invzmov`, `cxc`, etc. |
| Cotizaciones | `include/controler/pedidoactualizaprecios.inc.php:1207 deleteCotizacion()` → `:1215 $cotizacion->setEstadoCANCELADO()` |

- Pantalla: `html/views/cancelarpedido.view.php:304` (botón “Cancelar Pedido”).
- JS: `html/js/system/cancelarpedido.js:170` → `xajax_cancelarPedido(idPedido, motivo)`.
- Función: `include/controler/cancelarpedido.inc.php:223 cancelarPedido($idPedido, $motivo)`.

**Tablas tocadas**: `pedido` (`estado`,`fecha_cancelado`,`id_usuario_cancelado`,
`observacion_cancela`,`saldo`,`saldopromotor`), `cxc`/`cxcpromotor`, `invzmov` (reversos),
`pedidodetalle`.

---

## 5. Matriz resumen: transición → archivos clave

| Transición | Controladores / modelos | Triggers BD | Pantalla |
|---|---|---|---|
| alta→CAPTURADO | `pedidonuevo.inc.php`, `pedidoactualizaprecios.inc.php`, `model.pedido.inc.php` | `pedido_AFTER_INSERT`, `pedidodetalle_AFTER_INSERT` | `pedidonuevo.view.php` |
| CAPTURADO→AUTORIZADO | `pedido.inc.php`, `pedidonuevo.inc.php`, `prodpedido.inc.php`, `prompedpermitirvale.inc.php`, `colocarpedido.inc.php`, `model.pedido.inc.php`, `model.cotizacion.inc.php` | `cxc_AFTER_INSERT` | `pedido.view.php`, `colocarpedido.view.php` |
| AUTORIZADO→PRODUCCION | `pedido.inc.php`, `promopedidofechacompromiso.inc.php` | – | `pedido.view.php` |
| PRODUCCION→TERMINADO | `model.pedidodetalle.inc.php` (auto), `pedido.inc.php`, `despacharpedido.inc.php`, `surtestock.cron.php`, `registroproduccion.inc.php`, `pedidoobra.inc.php` | `invzmov_AFTER_INSERT`, `invzmovrollo_AFTER_INSERT`, `pedidodetalle_AFTER_UPDATE` | `despacharpedido.view.php`, `pedidoobra.view.php` |
| TERMINADO→ENRUTA | `asignarruta.inc.php` | `valesalida_AFTER_UPDATE` | `asignarruta.view.php` |
| ENRUTA→ENTREGADO | `asignarruta.inc.php`, `pedido.inc.php`, `promopedidofechacompromiso.inc.php`, `pedido.api.php` | `valesalida_AFTER_UPDATE` | `asignarruta.view.php`, `pedido.view.php` |
| →CANCELADO | `cancelarpedido.inc.php`, `pedidoactualizaprecios.inc.php` | – | `cancelarpedido.view.php` |

## 6. Triggers de BD relevantes (BD viva `mayamaria`)

| Trigger | Tabla | Efecto sobre pedido |
|---|---|---|
| `cxc_AFTER_INSERT` | `cxc` | Ajusta `pedido.saldo`; `saldada`, `fecha_saldada`; `cxcpromotor`; `cliente.procesarCreditos`. **No** cambia `estado`. |
| `valesalida_AFTER_UPDATE` | `valesalida` | `SALIDA` → `pedido.tipoRuta='ENRUTA'`; todos `ENTREGADO` + pedido `TERMINADO` → `pedido.estado='ENTREGADO'` + `pushnotifica`. |
| `pedidodetalle_AFTER_UPDATE` | `pedidodetalle` | `movsapartado` (APARTADO/DESAPARTADO); `valesalidadetalle` y bloques TERMINADO/ENTREGADO comentados en vivo. |
| `invzmov_AFTER_INSERT` | `invzmov` | `SALIDA` + `idPedidoDetalle>0` → actualiza `pedidodetalle` (partidadespachada, explotadoReal…), `pedidodetallecolocacion.cantidadSurtida`, existencias. |
| `invzmovrollo_AFTER_INSERT` | `invzmovrollo` | Idem para rollos. |
| `pedido_AFTER_INSERT` | `pedido` | Actualiza datos de `cliente`. |
| `pedido_AFTER_UPDATE` | `pedido` | Sin cambios de estado (mayormente comentado). |
| `pedidodetalle_AFTER_INSERT` / `pedidodetalle_BEFORE_INSERT` | `pedidodetalle` | Altas. |
| `pedidostracking_BEFORE_INSERT` | `pedidostracking` | Bitácora de estados. |
| `recibodinero_AFTER_INSERT` | `recibodinero` | `cliente.enviarPlanProteccion='SI'`. |

## 7. Crons
- **Web**: `runcronexplosion`, `runcronapartadosfix`, `runcronprocesapedidos`
  (`include/lib/app/routes.php:883-885`, solo `rol_ROOT`; lógica en `html/views/runcron*.view.php`).
- **CLI** (`include/cron/`): `explosion.cron.php`, `surtestock.cron.php`,
  `procesapedidos.cron.php`, `autorizaautomatico.cron.php`, `procesacreditos.cron.php`,
  `apartadosfix.cron.php`, `pushnotifica.cron.php`, `enviarplanproteccion.cron.php`.

## 8. APIs
- `html/api/pedido.api.php` – `:398` `setEstadoENTREGADO()` (app móvil).
- `html/api/pedidonuevo.api.php` – apoyo al alta (p. ej. `getRFCsCliente`).
- `html/api/cotizacion.api.php`, `html/api/colocarpedido.api.php` – re-explosión/colocación.
