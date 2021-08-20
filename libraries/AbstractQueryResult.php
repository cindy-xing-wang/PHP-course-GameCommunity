<?php
declare(strict_types = 1);

abstract class AbstractQueryResult
{
	abstract function __construct( $DB, $newQueryResource );
}