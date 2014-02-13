<?php

class TaskTest extends TestCase {

   public function testValidationWithNegativeTime() 
   {
      $task = new Task();
      $task->time_worked = -1;

      $this->assertEquals($task->validate(), false);
   }
   
   public function testValidationWithPositiveTime() 
   {
      $task = new Task();
      $task->time_worked = 1;

      $this->assertEquals($task->validate(), true);
   }
}
