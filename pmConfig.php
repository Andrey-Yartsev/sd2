<?php

return [
  'vhostAliases' => [
    '/sd/' => '{ngnEnvPath}/sd2/sd/'
  ],
  'afterCmdTttt' => [
    'php {runPath}/run.php site {name} {pmPath}/installers/common',
    'php {runPath}/run.php site {name} sd2/install',
  ]
];