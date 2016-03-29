<?php

return [
  'noDb'         => true,
  'vhostAliases' => [
    '/sd/' => '{ngnEnvPath}/bc-prod/sd/'
  ],
  'afterCmdTttt' => 'php {runPath}/run.php site {name} bc-prod/install'
];