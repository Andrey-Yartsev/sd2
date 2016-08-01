<?php

return [
  'vhostAliases' => [
    '/sd/' => '{ngnEnvPath}/bc/sd/'
  ],
  'afterCmdTttt' => [
    'php {runPath}/run.php site {name} {pmPath}/installers/common',
    'php {runPath}/run.php site {name} bc/install',
    //'pm localProject cc {name}',
  ]
];