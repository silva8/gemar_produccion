<?php session_start();
  require_once dirname(__FILE__) . "/../../include/lib.php";
  include_once dirname(__FILE__) . '/../../query/get_jornadas.php';
  include_once dirname(__FILE__) . '/../../query/get_last_reports.php';
  include_once dirname(__FILE__) . '/../../query/get_delayed_reports.php';
  $jornadas = get_jornadas();
  $reports = getLastReports();
  $delayed_reports = getDelayedReports();
?>
				<!--start container-->
				<div class="container">


					<!-- //////////////////////////////////////////////////////////////////////////// -->

					<!--card stats start-->
					<div id="card-stats">
						<div class="row">
							<div class="col s12 m6 l4">
								<div class="card">
									<div class="card-content  green white-text">
										<p class="card-stats-title">
											<i class="mdi-editor-insert-drive-file"></i> Media Jornadas
										</p>
										<h4 class="card-stats-number"><?php echo $jornadas[0]->media_jornada;?></h4>
										<p class="card-stats-compare">
											<span class="green-text text-lighten-5">Este mes</span>
										</p>
									</div>
									<div class="card-action  green darken-2">
										
									</div>
								</div>
							</div>
							<div class="col s12 m6 l4">
								<div class="card">
									<div class="card-content pink lighten-1 white-text">
										<p class="card-stats-title">
											<i class="mdi-editor-insert-drive-file"></i> Jornadas Completas
										</p>
										<h4 class="card-stats-number"><?php echo $jornadas[1]->jornada_completa;?></h4>
										<span class="pink-text text-lighten-5">Este mes</span>
									</div>
									<div class="card-action  pink darken-2">
										
									</div>
								</div>
							</div>
							<div class="col s12 m6 l4">
								<div class="card">
									<div class="card-content blue lighten-1 white-text">
										<p class="card-stats-title">
											<i class="mdi-editor-insert-drive-file"></i> Jornadas Residente
										</p>
										<h4 class="card-stats-number"><?php echo $jornadas[2]->jornada_residente;?></h4>
										<p class="card-stats-compare">
										<span class="blue-text text-lighten-5">Este mes</span>
										</p>
									</div>
									<div class="card-action blue darken-2">
										
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--card stats end-->

					<!-- //////////////////////////////////////////////////////////////////////////// -->

			
						<!-- //////////////////////////////////////////////////////////////////////////// -->

						<!--work collections start-->
						<div id="work-collections">
							<div class="row">
								<div class="col s12 m12 l6">
									<ul id="projects-collection" class="collection">
										<li class="collection-item avatar"><i
											class="mdi-action-assignment circle light-blue darken-2"></i> <span
											class="collection-header">Reportes recientes</span>
											<p>Este mes</p></li>
										<?php 
											foreach($reports as $report){ 
												echo '<li class="collection-item">
														<div class="row">
															<div class="col s6">
																<p class="collections-title">'.$report->nombre_proyecto.'</p>
																<p class="collections-content">'.$report->nombre.'</p>
															</div>
															<div class="col s3">
																<span class="task-cat blue-grey">'.$report->user_first_name.' '.$report->user_last_name.'</span>
															</div>
															<div class="col s3">
																<div class="progress">
																	<div class="determinate" style="width: '.$report->avance.'%"></div>
																</div>
																<span class="task-cat  pink lighten-4">Avance: '.$report->avance.'%</span>
															</div>
														</div>
													</li>';
											}
										?>
									</ul>
								</div>
								<div class="col s12 m12 l6">
									<ul id="issues-collection" class="collection">
										<li class="collection-item avatar"><i
											class="mdi-alert-warning circle red darken-2"></i> <span
											class="collection-header">Informes sin enviar</span>
											<p>Ordenados por fecha</p></li>
										<?php 
											foreach ($delayed_reports as $delayed){
												echo '<li class="collection-item">
														<div class="row">
															<div class="col s9">
																<p class="collections-title">'.$delayed->nombre_proyecto.'</p>
																<p class="collections-content">'.$delayed->nombre.'</p>
															</div>
															<div class="col s3">
																<span class="task-cat pink">'.$delayed->user_first_name.' '.$delayed->user_last_name.'</span>
															</div>
														</div>
													</li>';
											}
										?>										
									</ul>
								</div>
							</div>
						</div>
						<!--work collections end-->
					</div>
					<!--end container-->