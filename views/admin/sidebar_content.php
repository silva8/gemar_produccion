<li class="bold active sidebarlink">
	<a href="index.php" class="waves-effect waves-cyan">
		<i class="mdi-action-dashboard"></i>
		Dashboard
	</a>
</li>
<li class="bold sidebarlink">
	<a class="waves-effect waves-light modal-trigger modal-profile-trigger" href="#modal_calendario">
		<i class="mdi-editor-insert-invitation"></i>
		Calendario
	</a>
</li>
<li class="no-padding">
	<ul class="collapsible collapsible-accordion">
		<li class="bold sidebarlink">
			<a class="waves-effect waves-cyan load-content" href="#" what="views/app_todo.php" where="content">
				<i class="mdi-content-content-paste"></i>
				Reportes
			</a>
		</li>
		<li class="bold sidebarlink">
			<a class="waves-effect waves-light modal-trigger modal-profile-trigger" href="#modal_hojas">
				<i class="material-icons">timer</i>
				Hojas de Tiempo
			</a>
		</li>		
		<li class="bold sidebarlink">
			<a class="waves-effect waves-light modal-trigger modal-profile-trigger" href="#modal_logs">
				<i class="material-icons">timeline</i>
				Logs
			</a>
		</li>	
		<li class="bold sidebarlink">
			<a class="collapsible-header  waves-effect waves-cyan">
				<i class="mdi-action-account-circle"></i>
				Usuarios
			</a>
			<div class="collapsible-body">
				<ul>
					<li class="sidebarlink">
						<a class="waves-effect waves-light modal-trigger modal-profile-trigger" href="#modal_perfiles">Perfiles</a>
					</li>
					<li class="sidebarlink">
						<a href="#" what="views/admin/register_new_user.php" where="content" class="load-content">Registrar</a>
					</li>
				</ul>
			</div>
		</li>
		<li class="bold sidebarlink">
			<a class="collapsible-header  waves-effect waves-cyan">
				<i class="mdi-social-group"></i>
				Empresas
				</a>
			<div class="collapsible-body">
				<ul>
					<li class="sidebarlink">
						<a class="waves-effect waves-light load-content" href="#" what="views/admin/company.php" where="content">Agregar/Editar</a>
					</li>
				</ul>
			</div>
		</li>
		<li class="bold sidebarlink">
			<a class="collapsible-header  waves-effect waves-cyan">
				<i class="mdi-social-location-city"></i>
				Centros
				</a>
			<div class="collapsible-body">
				<ul>
					<li class="sidebarlink">
						<a class="waves-effect waves-light load-content" href="#" what="views/admin/centros.php" where="content">Agregar/Editar</a>
					</li>
				</ul>
			</div>
		</li>
		<li class="bold sidebarlink">
			<a class="collapsible-header  waves-effect waves-cyan">
				<i class="mdi-communication-quick-contacts-dialer"></i>
				Contactos
				</a>
			<div class="collapsible-body">
				<ul>
					<li class="sidebarlink">
						<a class="waves-effect waves-light load-content" href="#" what="views/admin/contactos.php" where="content">Agregar/Editar</a>
					</li>
				</ul>
			</div>
		</li>
	</ul>
</li>

