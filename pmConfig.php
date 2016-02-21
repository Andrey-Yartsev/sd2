<?php

return [
  'noDb'         => true,
  'vhostAliases' => [
    '/sd/' => '{ngnEnvPath}/sd/sd/'
  ],
  'afterCmdTttt' => 'php {runPath}/run.php site {name} sd/install'
];