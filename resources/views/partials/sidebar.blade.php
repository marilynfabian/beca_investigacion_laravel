<div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="index.html" class="site_title"><i class="fa fa-users"></i> <span>U.A.T.F.</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="{{ asset('images/img.jpg') }}" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>BIENVENIDO</span>
                <h2>JENNY MARILYN</h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>GENERAL</h3>
                <ul class="nav side-menu">
                  <li>
                    <a href="javascript:void(0)">
                        <i class="fa fa-home"></i> BECAS
                        <span class="fa fa-chevron-down"></span>
                    </a>

                    <ul class="nav child_menu">
                        <li>
                            <a href="javascript:void(0)">
                                BECA INVESTIGACION
                                <span class="fa fa-chevron-down"></span>
                            </a>

                            <ul class="nav child_menu">
                                <li class="sub_menu">
                                    <a href="{{ isset($postulacion) ? route('formulario-postulacion.show', $postulacion->id) : '#' }}">
                                        DATOS DE INVESTIGACION
                                    </a>
                                </li>

                                <li class="sub_menu">
                                    <a href="{{ isset($postulacion) ? route('cronograma.create', $postulacion->id) : '#' }}">
                                        CRONOGRAMA DE ACTIVIDADES
                                    </a>
                                </li>

                                <li class="sub_menu">
                                    <a href="{{ isset($estudiante) ? route('curriculum.create', $estudiante->ru) : '#' }}">
                                        CURRICULUM VITAE-C.V.
                                    </a>
                                </li>

                                <li class="sub_menu">
                                    <a href="{{ isset($estudiante) ? route('historial.index', $estudiante->ru) : '#' }}">
                                        HISTORIAL
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
                        <!-- /sidebar menu -->

                        <!-- /menu footer buttons -->
                      
                        <!-- /menu footer buttons -->
                      </div>
                    </div>