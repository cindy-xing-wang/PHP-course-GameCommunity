<?php
declare(strict_types = 1);

interface  DBInterface
{
	function connectToServer(): void;
	function selectDatabase(): void;
  function createDatabase(): void;
	function isError(): bool;
	function query( string $sql ): QueryResultInterface ;
}