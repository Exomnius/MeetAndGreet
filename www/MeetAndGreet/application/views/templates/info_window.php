
<div class="infoWindow">
	<div>
		<h4><i class="<?php print $catIcon; ?>"></i> <?php print $event->title. ' met '.$user['username']; ?></h4>
		<p><?php print $joinedCount. ' mensen doen mee.' ?></p>
	</div>
	<span><strong>Omschrijving</strong></span>
	<p class="float-left"><?php print $event->description; ?></p>
	<a href="#" onclick="joinEvent(<?php print $event->eventId; ?>)" class="btn btn-primary">Join</a>
	<a href="#" onclick="closeInfoWindow()" class="btn btn-default">Cancel</a>
</div>