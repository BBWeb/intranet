<?php

class LastQueryCache extends Eloquent {

  protected $table = 'lastquery_cache';

  protected $fillable = ['user_id', 'time'];

}