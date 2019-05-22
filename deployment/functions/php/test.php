<?php
function main(array $params) : array {
	$param = $params["param"] ?? "Mister";
	return ["PHP response" => "Hello $param, welcome at ISEP !"];
}