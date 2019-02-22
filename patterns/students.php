<?php

$candidates = new CandidateCollection();

$splitter = new PercentageSplitter($candidates, [25, 75]);
$splitter = new PercentageSplitter($candidates, [25, 5, 70]);

$splitted = $splitter->split(new ResultDescending($candidates));

foreach ($splitted as $list) {
    echo $sorter->sort($list);
}