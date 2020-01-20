# ansible-atom

This role helps to install Access to Memory (AtoM) in Linux (trusty, xenial and Centos / RedHat 7).

Please feel free to add support for other platforms, pull requests accepted!

Please visit our [deploy-pub](https://github.com/artefactual/deploy-pub/tree/master/playbooks/atom) repository for a real usage example.

## Notes on dependencies

- AtoM <=2.4, Binder 0.8: Elasticsearch>=1.3,<2.0
-   Atom 2.5, Binder 0.9: Elasticsearch>=5.3,<6.x

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