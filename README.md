# ansible-atom

This role helps to install Access to Memory (AtoM) in Linux (trusty, xenial, bionic, focal, jammy, noble, Centos/RedHat 7, Rocky/ALmalinux/Redhat 8, Rocky/ALmalinux/Redhat 9).

Please feel free to add support for other platforms, pull requests accepted!

Please visit our [deploy-pub](https://github.com/artefactual/deploy-pub/tree/master/playbooks/atom) repository for a real usage example.

## Notes on OS, AtoM version and php version

This role allows to install AtoM on CentOS 7 and Ubuntu 14.04, 16:04, 18.04 and
20.04. But not all the AtoM versions can be installed in all OS.

|AtoM version| PHP version    | CentOS/RH/Rocky support | Ubuntu support | ElasticSearch version | MySQL version |
|------------|----------------|-------------------------|----------------|-----------------------|---------------|
|  AtoM 2.3  |5.5, 5.6 and 7.0|     CentOS/RedHat 7     | 14.04 and 16.04|      >=1.3,<2.0       |  >=5.1,<6.0   |
|  AtoM 2.4  |5.5, 5.6 and 7.0|     CentOS/RedHat 7     | 14.04 and 16.04|      >=1.3,<2.0       |  >=5.1,<6.0   |
|  AtoM 2.5  |  7.0 and 7.2   |     CentOS/RedHat 7     | 16.04 and 18.04|      >=5.0,<6.0       |  >=5.1,<6.0   |
|  AtoM 2.6  |  7.2 and 7.3   |     CentOS/RedHat 7     |     18.04      |      >=5.0,<6.0       |     >=8.0     |
|  AtoM 2.7  |      7.4       |CentOS/RH 7, Rocky/RH 8-9|     20.04      |      >=5.0,<6.0       |     >=8.0     |
|  AtoM 2.8  |      7.4       |CentOS/RH 7, Rocky/RH 8-9|     20.04      |      >=5.0,<6.0       |     >=8.0     |
|  AtoM 2.9  | 8.1, 8.2, 8.3  |     RH 9, Rocky/RH 9    | 22.04 and 24.04|      >=6.0,<7.0       |     >=8.0     |
|  AtoM 2.10 | 8.1, 8.2, 8.3  |     RH 9, Rocky/RH 9    | 22.04 and 24.04|      >=7.0,<=7.10.2   |     >=8.0     |

The next table explains the valid `atom_php_version` values that you can use
depending on the AtoM version and Linux Distro. It is very important to take
into account the default value (last column), because if you need a different
php version you must set the `atom_php_version` variable on ansible `host_vars`
or `group_vars` files to the desired version.

|Linux Distro| AtoM 2.3 | AtoM 2.4 | AtoM 2.5 | AtoM 2.6 | AtoM 2.7 | AtoM 2.8 | AtoM 2.9 | AtoM 2.10 | Default |
|------------|----------|----------|----------|----------|----------|----------|----------|-----------|---------|
|CentOS/RH 7 |    70    |     70   | 70,71,72 |  72,73   |    74    |    74    |          |           |   72    |
|Rocky/RH 8  |          |          |          |          |    74    |    74    |          |           |   74    |
|Rocky/RH 9  |          |          |          |          |    74    |    74    | 81,82,83 |  81,82,83 |   74    |
|Ubuntu 14.04|     5    |      5   |          |          |          |          |          |           |    5    |
|Ubuntu 16.04|    7.0   |     7.0  |    7.0   |          |          |          |          |           |   7.0   |
|Ubuntu 18.04|          |          |    7.2   |   7.2    |          |          |          |           |   7.2   |
|Ubuntu 20.04|          |          |          |          |   7.4    |   7.4    |          |           |   7.4   |
|Ubuntu 22.04|          |          |          |          |          |          |   8.1    |    8.1    |   8.1   |
|Ubuntu 24.04|          |          |          |          |          |          |   8.3    |    8.3    |   8.3   |

From the table above, you can see the Linux distro you need depending on the
AtoM version. For instance, AtoM 2.6 can only be installed on CentOS 7 or
Ubuntu 18.04.

## Notes on dependencies

- AtoM <=2.4, Binder 0.8: Elasticsearch>=1.3,<2.0; MySQL>5.1,<6.0
- Atom 2.5, Binder 0.9: Elasticsearch>=5.3,<6.x; MySQL>5.1,<6.0
- AtoM 2.6-2.8: Elasticsearch>=5.3,<6.x; MySQL>=8.0
- AtoM 2.9:  Elasticsearch=>6.0,<7.0; MySQL>=8.0
- AtoM 2.10: Elasticsearch=>7.0,<=7.10.2; MySQL>=8.0


## Overriding default templates

A customized template can be loaded by your playbook in many cases by overriding
the default template path variable.  The following template path variables can
be redefined to load a customized template file (default path listed):

- atom_template_config_php: "atom/config/config.php"
- atom_template_app_yml: "atom/apps/qubit/config/app.yml"
- atom_template_factories_yml: "atom/apps/qubit/config/factories.yml"
- atom_template_settings_yml: "atom/apps/qubit/config/settings.yml"
- atom_template_gearman_yml: "atom/apps/qubit/config/gearman.yml"
- atom_template_search_yml: "atom/apps/qubit/config/{{ atom_es_config_version }}-search.yml"

Please note that you need to change the template path to load a customized
template, adding a customized template with the default path and name in your
playbook structure won't work.  E.g. Changing the "atom/config/config.php"
to "myatom/config/config.php" will load a template file at that relative
path in your playbook directory structure.

## Database initialization

By default, this role does not initialize the database. When first deploying
AtoM, use `-e atom_flush_data=yes` to force initialization which ensures that
AtoM's `tools:purge` task is executed during the deployment.

A new **experimental** variable (`atom_auto_init`) has been added to provide
**automatic database initialization** when the database is found empty. We
discourage the use this feature unless you are deploying ephemeral environments
such as those used in camps, demos or QA environments. In the long term, AtoM
may provide a CLI installer with safer guarantees that we could use in this
role.

## Deploy multiple sites on the same host

To deploy multiple AtoM sites on the same host, it is possible to have
an arrangement as follows:

```
.
|-- host_vars
|   `-- atomhost
|       |-- vars.yml       => variables common for all sites
|       |-- ...
|-- sites
|   |-- atomsite1.yml      => variables for site1
|   |-- atomsite2.yml      => variables for site2
|   |-- ...
|-- playbook-atom.yml      => AtoM deployment playbook
|-- ansible.cfg
|-- hosts
|-- ...
```

Where `atomsite1.yml`, `atomsite2.yml`, ... define role variables that
need to be different for site1, site2,...

As a minimum, the variable `atom_path` must be different for each site.
The basename of `atom_path` is used to create identifiers that need to be
different for each site, such as php pool and worker names (the basename
is the last component of the path, e.g., if `atom_path` is
"/usr/share/nginx/atom" then the basename is "atom")

For example, if deploying AtoM production and test sites, we could
define the production site variables in `atomsite1.yml`:

```
atom_path: "/usr/share/nginx/atom"
atom_config_db_name: "atom_prod"
atom_config_db_username: "atomuser_prod"
atom_config_db_password: "{{ vault_atomuser_prod_pass }}"
atom_es_index: "atom_prod"
```

And the test site variables in `atomsite2.yml`:

```
atom_path: "/usr/share/nginx/atom-test"
atom_config_db_name: "atom_test"
atom_config_db_username: "atomuser_test"
atom_config_db_password: "{{ vault_atomuser_test_pass }}"
atom_es_index: "atom_test"
```

To deploy AtoM dependencies and the first site on the host:
```
ansible-playbook playbook-atom.yml -l atomhost -e @sites/atomsite1.yml
```

Then to deploy the second site:
```
ansible-playbook playbook-atom.yml -l atomhost -e @sites/atomsite2.yml -t atom-site
```

The `-e @<file>` (extra vars) option makes ansible use the variables defined in the
specified file in addition to the variables defined in host_vars and the playbook
(with the values assigned as extra vars taking precedence over assignments
done elsewhere)

The `-t atom-site` option makes ansible execute only the tasks tagged
as `atom-site` in the role (i.e., tasks required to deploy a site)
and skip the tasks that are required only once per host deploy. The
database and user for the new site will also need to be configured in
the database server if not done already.

## Use a different revision dir for every site update

When the `atom_revision_directory` variable is set to `yes`, a new
`$atom_path/atom-COMMIT_ID` directory is created for every update and a
`$atom_path/$atom_revision_directory_latest_symlink_dir` symlink is created
pointing to the latest revision dir.

For instance:

```
/usr/share/nginx/atom
├── atom-0134577b6ecd763dedf82a7eee4ddc35043c5345
├── atom-1234567b6ecd763dedf92a7bad4ddc35043c5438
├── atom-381f849b6ecd763dedf92a7bad43cc350a3c5439
├── downloads
├── private -> /usr/share/nginx/atom/src
├── src -> /usr/share/nginx/atom/atom-381f849b6ecd763dedf92a7bad43cc350a3c5439
└── uploads
```

## Install and configure memprof extension and use `max-job-count` and `max-mem-limit` features

The `memprof` extension is needed by the following feature:

* https://projects.artefactual.com/issues/13573

The extension is downloaded from:

* https://github.com/arnaud-lb/php-memory-profiler

By default the module is not installed, you need to set as true or yes:

* `atom_php_install_memprof_module`

It has been tested on CentOS 7, Ubuntu 18 and Ubuntu 20.

An ansible config sample for AtoM qa/2.x and gearman:

```
atom_php_install_memprof_module: "yes"

atom_worker_systemd_memory_limit: "2000M"
atom_worker_systemd_execstart_php_extra_args: "-dextension=memprof.so"
atom_worker_systemd_start_limit_burst: "0"
atom_worker_systemd_restart_sec: "2"

atom_worker_systemd_execstart_worker_extra_args: "--max-job-count=10 --max-mem-usage=200000"

gearman_queue_parameters: "--queue-type=builtin --job-retries=1"
```

With the above config, the AtoM worker will be restarted (no daily restart
limit) after every job run and/or when using more than 200M of memory. Note the
`systemd_memory_limit` is 2GB and the `max-mem-usage` is 200MB, because
`systemd_memory_limit` must be higher than `max-mem-usage`.

## Development box

This role is also used to set up our [Vagrant box](vagrantbox) for development
purposes, including workflows where code changes and documentation work is
required.

The role variable that controls this behaviour is `atom_environment_type` when
its value is set to `development`. However, this is only known to work in the
context of Vagrant and builds based on Ubuntu, e.g. it assumes that the `vagrant`
user has been previously created.

vagrantbox: https://www.accesstomemory.org/en/docs/latest/dev-manual/env/vagrant/

## License

AGPL-3.0.

Composer management based on [Ansible Role: Composer] (Jeff Geerling, MIT).


[Ansible Role: Composer]: https://github.com/geerlingguy/ansible-role-composer
