
<li class="bold sidebarlink">
	<a class="waves-effect waves-cyan load-content" href="#" what="views/user_profile_page.php" where="content">
		<i class="mdi-action-account-circle"></i>
		Perfil
	</a>
</li>

<li class="bold sidebarlink">
	<a class="waves-effect waves-light load-content" href="#" what="views/app_calendar.php" where="content">
		<i class="mdi-editor-insert-invitation"></i>
		Calendario
	</a>
</li>

<li class="bold active sidebarlink">
	<a class="waves-effect waves-cyan load-content" what="views/app_todo.php" where="content" class="load-content">
		<i class="mdi-action-assignment"></i>
		Reportes
	</a>
</li>

<?php
	$user = get_users($_SESSION['user_id'])[0];
	echo '<li class="bold sidebarlink">
			<a class="waves-effect waves-light load-content" what="views/admin/hojas_tiempo.php?id='.$user->user_id.'&name='.$user->user_first_name.'&lastname='.$user->user_last_name.'" where="content">
				<i class="material-icons">timer</i>
					Hojas de Tiempo
			</a>
		</li>';
?>
