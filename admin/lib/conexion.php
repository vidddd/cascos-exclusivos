<?php

$mysqli = new mysqli($config->db->server, $config->db->user, $config->db->pass, $config->db->dbname);
if ($mysqli->connect_error) {
		die('Connection Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
	}
?>