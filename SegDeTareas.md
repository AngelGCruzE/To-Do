## Login tareas

la base de datos es bulnerable porque guarda directa la contraseña (hay que usar un hash)

## index

agregar un boton para borrar tareas en especifico 

# Acciones realizadas
-se añadieron alertas a todas las acciones (tarea realizada, usuarios creados, contraseñas y usuarios duplicados)
### seguridad 1.5 hrs
#### funcion login
-Se preparo la consulta para evitar sqli
-se añadio la funcion password_hash para encriptar las contraseñas

#### funcion sing up
-se preparo consulta para evitar sqli 
-se añadio la funcion password_ verify para comparar los hashes de la contraseña

#### SingUp y Login 4hrs
- se elimino login.php y singup.php ya que se unifico en userLS.php ahora este archivo hace las dos funciones aparte de tener un diseño mas 

    # Roles

    Angel // dev - Analista
    Rayundo // Dev - Diseñador
    Choi // dev - Diseñador

    Adriana // analista - tester
    Miriam // PO - Analista
    Marina // tester - Auditor (PO)

#### modificar la base de datos 1.5hrs
añadir campos necesarios para cumplir con los requerimientos
users{id,correo,usuario,contraseña,avatar}
todos {id,user_id,task,state,fecha}

#### adaptacoin de index (2h y contando)
-modificar la sesion activa con los nuevos parametros de la base
-añadir la opcion de fecha a la creacion de tareas pq no hay predeterminada y esto causa error 
-modificar la tabla de tareas para que muestre la fecha
-poner una causula que aga que las tareas "venzan" despues de la fecha establecida
-se movio la funcion de cerrar session a la pestaña/apartado configuracion
-añadir la funcion de vencimiento para las tareas (funciona con la fecha)


#### notificaciones
-hacer una funcion que mande un correo de prueba al correo registrado con el fin de verificar si el correo es el correcto
-añadir la opcion de activar las notificaciones (en la pantalla config)
- crear una funcion que valid