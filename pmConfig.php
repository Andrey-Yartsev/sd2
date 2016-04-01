<?php

return [
  'noDb'         => true,
  'vhostAliases' => [
    '/sd/' => '{ngnEnvPath}/bc/sd/'
  ],
  'afterCmdTttt' => 'php {runPath}/run.php site {name} sd/install'
];