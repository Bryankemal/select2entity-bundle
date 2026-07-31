<?php

// Remplace Resources/config/services.xml : Symfony 8 a supprimé
// Symfony\Component\DependencyInjection\Loader\XmlFileLoader.
// Adapter aussi TetranzSelect2EntityExtension::load() :
//   - new Loader\PhpFileLoader(...)  (au lieu de new Loader\XmlFileLoader(...))
//   - $loader->load('services.php'); (au lieu de 'services.xml')

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;
use Tetranz\Select2EntityBundle\Service\AutocompleteService;

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services->set('tetranz_select2entity.select2entity_type', Select2EntityType::class)
        ->tag('form.type', ['alias' => 'tetranz_select2entity'])
        ->args([
            service('doctrine'),
            service('router'),
            '%tetranz_select2_entity.config%',
        ]);

    $services->set('tetranz_select2entity.autocomplete_service', AutocompleteService::class)
        ->args([
            service('form.factory'),
            service('doctrine'),
        ]);
};
