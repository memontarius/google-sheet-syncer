<?php

use Illuminate\Support\Facades\Schedule;


Schedule::command('app:sync-google-sheet')->everyMinute()->runInBackground();
