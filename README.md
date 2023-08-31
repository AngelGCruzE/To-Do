## Login tareas

la base de datos es bulnerable porque guarda directa la contraseña (hay que usar un hash)

## index

agregar un boton para borrar tareas en especifico 

# Acciones realizadas
-se añadieron alertas a todas las acciones (tarea realizada, usuarios creados, contraseñas y usuarios duplicados)
### actions.php
#### funcion login
-Se preparo la consulta para evitar sqli
-se añadio la funcion password_hash para encriptar las contraseñas

#### funcion sing up
-se preparo consulta para evitar sqli 
-se añadio la funcion password_ verify para comparar los hashes de la contraseña


# Roles

Angel // dev - 
Rayundo // Dev - 
Choi // dev - 

Adriana // analista - 
Miriam // PO - 
Marina // tester - 
