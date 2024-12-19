<?php

use App\Jobs\GetNewsJob;
use Illuminate\Support\Facades\Schedule;


Schedule::job(new GetNewsJob)->everyMinute();
