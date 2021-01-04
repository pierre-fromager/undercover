# :elephant: undercover

[![TravsisBadgeBuild](https://travis-ci.com/pierre-fromager/undercover.svg?branch=master)](https://travis-ci.com/pierre-fromager/undercover)
[![Coverage](https://scrutinizer-ci.com/g/pierre-fromager/undercover/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/pierre-fromager/undercover/)
[![ScrutinizerScore](https://scrutinizer-ci.com/g/pierre-fromager/undercover/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/pierre-fromager/undercover/)
[![Latest Stable Version](https://poser.pugx.org/pier-infor/undercover/v/stable)](https://packagist.org/packages/pier-infor/undercover)
[![Total Downloads](https://poser.pugx.org/pier-infor/undercover/downloads)](https://packagist.org/packages/pier-infor/undercover)
[![Latest Unstable Version](https://poser.pugx.org/pier-infor/undercover/v/unstable)](https://packagist.org/packages/pier-infor/undercover)

Undercover is a php clover coverage checker

## Setup

``` bash
composer require pier-infor/undercover
```

## Integration

``` php
<?php

use PierInfor\Undercover\Checker;

exit((new Checker)->run());
```

## Arguments

* -f &nbsp;,&nbsp; --file
  * clover file path. 
* -l &nbsp;,&nbsp; --lines
  * threshold for covered lines. 
* -m &nbsp;,&nbsp; --methods
  * threshold for covered methods. 
* -s &nbsp;,&nbsp; --statements
  * threshold for covered statements. 
* -c &nbsp;,&nbsp; --classes
  * threshold for covered classes. 
* -b &nbsp;,&nbsp; --blocking
  * flag to set exit code to 1 when error happened.

*(threshold as percent value)*
