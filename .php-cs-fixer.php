<?php

$config = \TYPO3\CodingStandards\CsFixerConfig::create();
$config->getFinder()
    ->ignoreVCS(true)
    ->ignoreVCSIgnored(true)
    ->notName(['ext_localconf.php', 'ext_tables.php', 'ext_emconf.php', 'additional.php'])
    ->exclude(['Tests/Acceptance/Support/_generated/'])
    ->in(__DIR__);
$config->addRules(
    [
        'yoda_style' => false, // dude, I love yoda style
        'function_declaration' => [
            'closure_function_spacing' => 'none',
            'closure_fn_spacing' => 'none',
        ],
        'single_line_empty_body' => false,
        'cast_spaces' => ['space' => 'single'],
    ]
);

return $config;
