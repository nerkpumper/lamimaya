# Scripts para insertar nuevos productos

## Orden de ejecucion

1. **01_insertar_proveedores.sql** - Inserta proveedores
2. **02_insertar_aplicacion_material.sql** - Inserta aplicaciones y materiales
3. **03_insertar_rollos.sql** - Inserta rollos (depende de material y proveedor)
4. **04_insertar_productos.sql** - Inserta productos (depende de aplicacion, material, rollo)
5. **05_verificacion.sql** - Verifica los datos insertados

## Ejecucion

```bash
# 1. Proveedores
docker exec -i lamimaya-db-1 mysql -u root -p'mayaroot123' mayamaria < 01_insertar_proveedores.sql

# 2. Aplicaciones y materiales
docker exec -i lamimaya-db-1 mysql -u root -p'mayaroot123' mayamaria < 02_insertar_aplicacion_material.sql

# 3. Rollos
docker exec -i lamimaya-db-1 mysql -u root -p'mayaroot123' mayamaria < 03_insertar_rollos.sql

# 4. Productos
docker exec -i lamimaya-db-1 mysql -u root -p'mayaroot123' mayamaria < 04_insertar_productos.sql

# 5. Verificacion
docker exec -i lamimaya-db-1 mysql -u root -p'mayaroot123' mayamaria < 05_verificacion.sql
```

## Archivos

- 01: 3 proveedores
- 02: 17 aplicaciones, 21 materiales
- 03: 36 rollos
- 04: 420 productos
- 05: Verificacion

## Notas

- Los scripts usan `ON DUPLICATE KEY UPDATE` para evitar duplicados
- Los productos usan subconsultas para obtener los IDs de FK
- Si un material/aplicacion/rollo no existe, el producto se salta (WHERE NOT EXISTS)
