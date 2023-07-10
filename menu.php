<?php
 require_once 'sesion.php';
 require_once './config/conexion.php';
 $idb = $conn;                          
 cargarmenu("0",$idb); // Donde 0 es el Idpadre principal			   

                            function cargarmenu($id,$idb) {
                                $sql = "SELECT 
                                                        M.codmodulo,
                                                        M.descripcion AS descripcion,
                                                        M.url,
                                                        M.idpadre,
                                                        M.icono
                                                        FROM
                                                        modulo_tipousuario AS MTU
                                                        Inner Join  tbl_modulos AS M ON MTU.codmodulo = M.codmodulo
                                                        Inner Join  tbl_tipousuario AS TU ON TU.id_tipousuario = MTU.id_tipousuario
                                                        WHERE  MTU.id_tipousuario=". $_SESSION['id_tipousuario'] . " and M.estado='1' and idpadre='$id' ORDER BY M.order_list DESC";
                                $query = $idb->prepare($sql); 
                                $query->execute(); 
                                $resultado = $query->fetchAll();
                                foreach ($resultado as $f) {
                                    $descripcion = $f['descripcion'];
                                    $url = $f['url'];
                                    $icono = $f['icono'];                                  
                                    if ($url == "#") {
                                       
                                        echo '<li class="nav-item">';
                                        echo '<a href="#" class="nav-link">';
                                         
                                        echo '<i class="nav-icon fas '.$icono.'"></i>
                                               <p>'.$descripcion.' <i class="fas fa-angle-left right"></i>
                                               </p>
                                             </a>
                                              ';
                                        echo '<ul class="nav nav-treeview">';
                                         cargarmenu($f['codmodulo'],$idb);
                                         echo '</ul>';
                                        echo "</li>";
                                        
                                    } else {

                                        echo "<li class='nav-item'><a href='#' class='nav-link' onclick='loadpage(".'"'.$url.'"'.")' ><i class='far ".$icono." nav-icon'></i>" . " " . $descripcion . "</a></li>";
                                     }
                                    
                                }
                            }
                            ?>