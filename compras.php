<?php
session_start();
if(!empty($_SESSION["userId"])) {
    require_once('compras/Modelo/compras.php');
    $Modelo = new Compras();
    $Empleado = $Modelo->getEmpleado($_SESSION["userId"]);
    if (!$Empleado) {
        $_SESSION["errorMessage"] = "Invalid Credentials";
        header('Location: logout.php');
    } else {
        $desactivado = $Modelo->getEstatusEmpleado($_SESSION["userId"]);
        if ($desactivado[0][0] == 1) {
            $_SESSION["errorMessage"] = "Invalid Credentials";
            header('Location: logout.php');
        } else {
            $nombreEmpleado = $Empleado[0]["nombre"];
            $apellidoEmpleado = $Empleado[0]["apellidos"];
            require_once('empleados/Modelo/empleados.php');
            $ModeloEmpleados = new Empleados();
            require_once('proveedores/Modelo/proveedores.php');
            $ModeloProveedores = new Proveedores();
            require_once('productos/Modelo/productos.php');
            $ModeloProductos = new Productos();        
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

    <title>Compras</title>

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
                        <h1 class="h3 mb-0 text-gray-800">Compras</h1>
                    </div>

                    <?php
                        if(!empty($_GET['editarId'])) {
                        //cuando pide editar Compra:
                        $id = $_GET['editarId'];
                        $datosDeCompra = $Modelo->getCompra($id);
                        if($datosDeCompra != null){
                            foreach($datosDeCompra as $datoCompra){
                    ?>

                    <div class="row">
                        <div class="col-md-6">
                            <form class="user" action="compras/Controlador/editCompra.php" method="POST" enctype="multipart/form-data">
                                <input name="id" type="hidden" value="<?php echo $id;?>" />
                                <div class="form-group">
                                    <select class="form-control" name="id_proveedor">
                                        <?php
                                            $listaProveedores = $ModeloProveedores->get();
                                            if($listaProveedores != null){
                                                foreach($listaProveedores as $proveedor){
                                                    echo '<option value="'.$proveedor['id'].'"';
                                                    if ($datoCompra['id_proveedor'] == $proveedor['id']) {echo " selected";}
                                                    echo '>'.$proveedor['nombre'].'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select class="form-control" name="id_producto">
                                        <?php
                                            $listaProductos = $ModeloProductos->get();
                                            if($listaProductos != null){
                                                foreach($listaProductos as $producto){
                                                    echo '<option value="'.$producto['id'].'"';
                                                    if ($datoCompra['id_producto'] == $producto['id']) {echo " selected";}
                                                    echo '>'.$producto['codigo'].'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input required type="text" class="form-control" value="<?php echo $datoCompra['importe'];?>" name="importe">
                                </div>
                                <div class="form-group">
                                    <input requiredtype="text" class="form-control" value="<?php echo $datoCompra['no_pedido'];?>" name="no_pedido">
                                </div>
                                <input type ="submit" class="btn btn-primary btn-user btn-block" value="Editar Compra">
                                <hr>
                            </form>
                        </div>
                    </div>
                    <hr>
                    <?php
                            }
                            }
                        } else { //cuando no esta pidiendo editar Compra:
                    ?>

                    <div class="row">
                        <div class="col-md-6">
                            <form class="user" action="compras/Controlador/addCompra.php" method="POST" enctype="multipart/form-data">
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
                                <div class="form-group">
                                    <select class="form-control" name="id_producto">
                                        <?php
                                            $listaProductos = $ModeloProductos->getActivos();
                                            if($listaProductos != null){
                                                foreach($listaProductos as $producto){
                                                    echo '<option value="'.$producto['id'].'">'.$producto['codigo'].'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input required type="text" class="form-control" placeholder="Importe" name="importe">
                                </div>
                                <div class="form-group">
                                    <input required type="text" class="form-control" placeholder="Numero de pedido" name="no_pedido">
                                </div>
                                <input type ="submit" class="btn btn-primary btn-user btn-block" value="Registrar Compra">
                                <hr>
                            </form>
                        </div>
                    </div>
                    <?php
                        } //cierra else para cuando no esta pidiendo editar Compra
                    ?>
                     <div class="card shadow mb-4 col-lg w-100">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">COMPRAS</h6>
                        </div>
                        <div class="card-body" >
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <th></th>
                                    <th>id</th>
                                    <th>tabla_id</th>
                                    <th>id_proveedor</th>
                                    <th>nombre proveedor</th>
                                    <th>id_producto</th>
                                    <th>codigo producto</th>
                                    <th>fecha_pedido</th>
                                    <th>fecha_factura</th>
                                    <th>importe</th>
                                    <th>no_pedido</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                <?php
                                    $compras = $Modelo->get();
                                    if($compras != null){
                                        foreach($compras as $compra){
                                ?>
                                    <tr>
                                        <td><a href="compras.php?editarId=<?php echo $compra['id'];?>"><span class="fa fa-edit" style="color: blue;"></span></a></td>
                                        <td><?php echo $compra['id'];?></td>
                                        <td><?php echo $compra['tabla_id'];?></td>
                                        <td><?php echo $compra['id_proveedor'];?></td>
                                        <td><?php $proveedorRow = $ModeloProveedores->getProveedor($compra['id_proveedor']);echo $proveedorRow[0]["nombre"];?></td>                                        
                                        <td><?php echo $compra['id_producto'];?></td>
                                        <td><?php $productoRow = $ModeloProductos->getProducto($compra['id_producto']);echo $productoRow[0]["codigo"];?></td>
                                        <td><?php echo $compra['fecha_pedido'];?></td>
                                        <td><?php echo $compra['fecha_factura'];?></td>
                                        <td><?php echo $compra['importe'];?></td>
                                        <td><?php echo $compra['no_pedido'];?></td>
                                        <td>
                                        <a href="compras/Vista/delete.php?Id=<?php echo $compra['id'];?>"><span class="fa fa-trash" style="color: red;"></span></a>
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