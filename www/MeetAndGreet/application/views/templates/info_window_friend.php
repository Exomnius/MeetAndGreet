
<?php 
$last_login = date_create($user['last_login']);
$now = new DateTime();
$difference = $now->diff($last_login);
 ?>

<div class="infoWindow">
	<h4><i class=""></i><?php print $user['username']; ?></h4>
	<p>Last seen <?php print $difference->format("%H hours and %i minutes ago."); ?></p>
	<a href="#" onclick="closeInfoWindow()" class="btn btn-default">Close</a>
</div>