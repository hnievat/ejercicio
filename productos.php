<?php
session_start();
if(!empty($_SESSION["userId"])) {
    require_once('productos/Modelo/productos.php');
    $Modelo = new Productos();
    $Empleado = $Modelo->getEmpleado($_SESSION["userId"]);
    if (!$Empleado) {
        $_SESSION["errorMessage"] = "Invalid Credentials";
        header('Location: logout.php');
    } else {
        $desactivado = $Modelo->getEstatusEmpleado($_SESSION["userId"]);
        if ($desactivado[0][0] == 1) {
            session_destroy();
            $_SESSION["errorMessage"] = "Invalid Credentials";
            header('Location: logout.php');
        } else {
            $nombreEmpleado = $Empleado[0]["nombre"];
            $apellidoEmpleado = $Empleado[0]["apellidos"];
            require_once('empleados/Modelo/empleados.php');
            $ModeloEmpleados = new Empleados();
            require_once('proveedores/Modelo/proveedores.php');
            $ModeloProveedores = new Proveedores();
        }
    }
} else {
    header('Location: logout.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Productos</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="empleados.php">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Empleados</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="productos.php">
                    <i class="fas fa-fw fa-list"></i>
                    <span>Productos</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="proveedores.php">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Proveedores</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="compras.php">
                    <i class="fas fa-fw fa-list"></i>
                    <span>Compras</span></a>
            </li>
            
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $nombreEmpleado.' '.$apellidoEmpleado?></span>
                                <img class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="index.php" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Productos</h1>
                    </div>

                    <?php
                        if(!empty($_GET['editarId'])) {
                        //cuando pide editar Producto:
                        $id = $_GET['editarId'];
                        $datosDeProducto = $Modelo->getProducto($id);
                        if($datosDeProducto != null){
                            foreach($datosDeProducto as $datoProducto){
                    ?>

                    <div class="row">
                        <div class="col-md-6">
                            <form class="user" action="productos/Controlador/editProducto.php" method="POST" enctype="multipart/form-data">
                                <input name="id" type="hidden" value="<?php echo $id;?>" />
                                <input name="id_empleado" type="hidden" value="<?php echo $_SESSION["userId"];?>" />
                                <div class="form-group">
                                    <input required type="text" class="form-control" value="<?php echo $datoProducto['codigo'];?>" name="codigo">
                                </div>
                                <div class="form-group">
                                    <input required type="text" class="form-control" value="<?php echo $datoProducto['marca'];?>" name="marca">
                                </div>
                                <div class="form-group">
                                    <select class="form-control" name="estado">
                                        <option value="bueno" <?php if ($datoProducto['estado']=="bueno"){echo "selected";}?>>bueno</option>
                                        <option value="dañado" <?php if ($datoProducto['estado']=="dañado"){echo "selected";}?>>dañado</option>
                                        <option value="baja" <?php if ($datoProducto['estado']=="baja"){echo "selected";}?>>baja</option>
                                    </select> 
                                </div>
                                <div class="form-group">
                                    <input required type="text" class="form-control" value="<?php echo $datoProducto['categoria'];?>" name="categoria">
                                </div>
                                <div class="form-group">
                                    <input requiredtype="text" class="form-control" value="<?php echo $datoProducto['precio'];?>" name="precio">
                                </div>
                                <div class="form-group">
                                    <input requiredtype="text" class="form-control" value="<?php echo $datoProducto['existencia'];?>" name="existencia">
                                </div>
                                <div class="form-group">
                                    <select class="form-control" name="id_empleado">
                                        <?php
                                            $listaEmpleados = $ModeloEmpleados->get();
                                            if($listaEmpleados != null){
                                                foreach($listaEmpleados as $empleado){
                                                    echo '<option value="'.$empleado['id'].'"';
                                                    if ($datoProducto['id_empleado'] == $empleado['id']) {echo " selected";}
                                                    echo '>'.$empleado['nombre'].' '.$empleado['apellidos'].'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select class="form-control" name="id_proveedor">
                                        <?php
                                            $listaProveedores = $ModeloProveedores->get();
                                            if($listaProveedores != null){
                                                foreach($listaProveedores as $proveedor){
                                                    echo '<option value="'.$proveedor['id'].'"';
                                                    if ($datoProducto['id_proveedor'] == $proveedor['id']) {echo " selected";}
                                                    echo '>'.$proveedor['nombre'].'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select class="form-control" name="desactivado">
                                        <?php
                                            if ($datoProducto['desactivado'] == FALSE) {
                                                echo '<option value="0" selected>Activo</option>';
                                                echo '<option value="1">Inactivo</option>';
                                            } else {
                                                if ($datoProducto['desactivado'] == TRUE) {
                                                    echo '<option value="0">Activo</option>';
                                                    echo '<option value="1" selected>Inactivo</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <input type ="submit" class="btn btn-primary btn-user btn-block" value="Editar Producto">
                                <hr>
                            </form>
                        </div>
                    </div>
                    <hr>
                    <?php
                            }
                            }
                        } else { //cuando no esta pidiendo editar Producto:
                    ?>

                    <div class="row">
                        <div class="col-md-6">
                            <form class="user" action="productos/Controlador/addProducto.php" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <input required type="text" class="form-control" placeholder="Codigo" name="codigo">
                                </div>
                                <div class="form-group">
                                    <input required type="text" class="form-control" placeholder="Marca" name="marca">
                                </div>
                                <div class="form-group">
                                    <select class="form-control" name="estado">
                                        <option value="bueno" selected>bueno</option>
                                        <option value="dañado">dañado</option>
                                        <option value="baja">baja</option>
                                    </select> 
                                </div>
                                <div class="form-group">
                                    <input required type="text" class="form-control" placeholder="Categoria" name="categoria">
                                </div>
                                <div class="form-group">
                                    <input required type="text" class="form-control" placeholder="Precio" name="precio">
                                </div>
                                <div class="form-group">
                                    <input required type="text" class="form-control" placeholder="Existencia" name="existencia">
                                </div>
                                <!-- <input name="id_empleado" type="hidden" value="<?php echo $_SESSION["userId"];?>" /> -->
                                <div class="form-group">
                                    <select class="form-control" name="id_empleado">
                                        <?php
                                            $listaEmpleados = $ModeloEmpleados->getActivos();
                                            if($listaEmpleados != null){
                                                foreach($listaEmpleados as $empleado){
                                                    echo '<option value="'.$empleado['id'].'">'.$empleado['nombre'].' '.$empleado['apellidos'].'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select class="form-control" name="id_proveedor">
                                        <?php
                                            $listaProveedores = $ModeloProveedores->getActivos();
                                            if($listaProveedores != null){
                                                foreach($listaProveedores as $proveedor){
                                                    echo '<option value="'.$proveedor['id'].'">'.$proveedor['nombre'].'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <input type ="submit" class="btn btn-primary btn-user btn-block" value="Registrar Producto">
                                <hr>
                            </form>
                        </div>
                    </div>
                    <?php
                        } //cierra else para cuando no esta pidiendo editar Producto
                    ?>
                     <div class="card shadow mb-4 col-lg w-100">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">PRODUCTOS</h6>
                        </div>
                        <div class="card-body" >
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <th></th>
                                    <th>id</th>
                                    <th>tabla_id</th>
                                    <th>codigo</th>
                                    <th>marca</th>
                                    <th>estado</th>
                                    <th>categoria</th>
                                    <th>precio</th>
                                    <th>existencia</th>
                                    <th>id_empleado</th>
                                    <th>nombre y apellido empleado</th>
                                    <th>id_proveedor</th>
                                    <th>nombre proveedor</th>
                                    <th>estatus</th>
                                </thead>
                                <tbody>
                                <?php
                                    $productos = $Modelo->get();
                                    if($productos != null){
                                        foreach($productos as $producto){
                                ?>
                                    <tr>
                                        <td><a href="productos.php?editarId=<?php echo $producto['id'];?>"><span class="fa fa-edit" style="color: blue;"></span></a></td>
                                        <td><?php echo $producto['id'];?></td>
                                        <td><?php echo $producto['tabla_id'];?></td>
                                        <td><?php echo $producto['codigo'];?></td>
                                        <td><?php echo $producto['marca'];?></td>
                                        <td><?php echo $producto['estado'];?></td>
                                        <td><?php echo $producto['categoria'];?></td>
                                        <td><?php echo $producto['precio'];?></td>
                                        <td><?php echo $producto['existencia'];?></td>
                                        <td><?php echo $producto['id_empleado'];?></td>
                                        <td><?php $empleadoRow = $Modelo->getEmpleado($producto['id_empleado']);echo $empleadoRow[0]["nombre"]." ".$empleadoRow[0]["apellidos"];?></td>
                                        <td><?php echo $producto['id_proveedor'];?></td>
                                        <td><?php $proveedorRow = $ModeloProveedores->getProveedor($producto['id_proveedor']);echo $proveedorRow[0]["nombre"];?></td>                                        
                                        <td>
                                            <?php 
                                                if ($producto['desactivado']==FALSE) {
                                                    echo "Activo";
                                                }else{
                                                    if ($producto['desactivado']==TRUE) {
                                                        echo "Inactivo";
                                                    }
                                                }
                                            ?>
                                        </td>
                                    </tr>
                                <?php        
                                        }
                                    }
                                ?>
                                </tbody>
                            </table>
                            </div>
                     </div>
                    
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright 2022</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

</body>

</html>