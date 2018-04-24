<?php
use App\Updates\SiteUpdateManager;
use Symfony\Component\DependencyInjection\Definition;

// To use as default template
$definition = new Definition();

$definition
    ->setAutowired(true)
    ->setAutoconfigured(true)
    ->setPublic(false)
;

// $this is a reference to the current loader
$this->registerClasses($definition, 'App\\', '../src/*', '../src/{Entity,Migrations,Tests}');

// Explicitly configure the service
$container->getDefinition(SiteUpdateManager::class)
    ->setArgument('$adminEmail', 'manager@example.com');