<?php

use Flarum\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

return Migration::createTable('email_rules', function (Blueprint $table) {
  $table->increments('id');
  $table->integer('rule_type');
  $table->string('name');
  $table->string('value');
  $table->boolean('active');
});
