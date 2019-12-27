<?php

# Ansible managed file, do not edit directly

return array (
  'all' =>
  array (
    'propel' =>
    array (
      'class' => 'sfPropelDatabase',
      'param' =>
      array (
        'encoding' => '{{ atom_config_db_encoding }}',
        'persistent' => true,
        'pooling' => true,
        'dsn' => 'mysql:dbname={{ atom_config_db_name }};host={{ atom_config_db_hostname }};port={{ atom_config_db_port }}',
        'username' => '{{ atom_config_db_username }}',
        'password' => '{{ atom_config_db_password }}',
      ),
    ),
  ),
  'dev' =>
  array (
    'propel' =>
    array (
      'param' =>
      array (
        'classname' => 'DebugPDO',
        'debug' =>
        array (
          'realmemoryusage' => true,
          'details' =>
          array (
            'time' =>
            array (
              'enabled' => true,
            ),
            'slow' =>
            array (
              'enabled' => true,
              'threshold' => 0.10000000000000001,
            ),
            'mem' =>
            array (
              'enabled' => true,
            ),
            'mempeak' =>
            array (
              'enabled' => true,
            ),
            'memdelta' =>
            array (
              'enabled' => true,
            ),
          ),
        ),
      ),
    ),
  ),
  'test' =>
  array (
    'propel' =>
    array (
      'param' =>
      array (
        'classname' => 'DebugPDO',
      ),
    ),
  ),
);
