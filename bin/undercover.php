#!/usr/bin/env php
<?php

require_once '../vendor/autoload.php';

use PierInfor\Undercover\Checker;

exit((new Checker)->run());