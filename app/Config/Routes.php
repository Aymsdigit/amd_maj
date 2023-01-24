<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('category', 'Home::category');
$routes->post('fetch-categories', 'Category::fetch_categorie');
$routes->post('insert', 'Category::insert');
$routes->post('show', 'Category::show');
$routes->post('delete', 'Category::delete');

$routes->get('article', 'Home::Article');
$routes->post('fetch-article', 'Article::fetch_article');
$routes->post('load-article', 'Article::load_article');
$routes->post('insert', 'Article::insert');
$routes->post('show', 'Article::show');
$routes->post('delete', 'Article::delete');

$routes->get('approvisionnement', 'Home::Approvisionnement');
$routes->post('fetch-approvisionnement', 'Approvisionnement::fetch_approvisionnement');
$routes->post('fetch-global', 'Approvisionnement::fetch_global');
$routes->post('insert', 'Approvisionnement::insert');
$routes->post('show', 'Approvisionnement::show');
$routes->post('delete', 'Approvisionnement::delete');

$routes->get('fournisseur', 'Home::Fournisseur');
$routes->post('fetch-fournisseur', 'Fournisseur::fetch_fournisseur');
$routes->post('fetch-global', 'Fournisseur::fetch_global');
$routes->post('insert', 'Fournisseur::insert');
$routes->post('show', 'Fournisseur::show');
$routes->post('delete', 'Fournisseur::delete');

$routes->get('perte', 'Home::Perte');
$routes->post('fetch-perte', 'Perte::fetch_perte');
$routes->post('fetch-global', 'Perte::fetch_global');
$routes->post('insert', 'Perte::insert');
$routes->post('show', 'Perte::show');
$routes->post('delete', 'Perte::delete');

$routes->get('vente', 'Home::Vente');
$routes->post('fetch-vente', 'Vente::fetch_vente');
$routes->post('fetch-global', 'Vente::fetch_global');
$routes->post('insert', 'Vente::insert');
$routes->post('show', 'Vente::show');
$routes->post('delete', 'Vente::delete');

$routes->get('credit', 'Home::credit');
$routes->post('fetch-credit', 'Credits::fetch_Credits');
$routes->post('insert', 'Credits::insert');
$routes->post('show', 'Credits::show');
$routes->post('delete', 'Credits::delete');

$routes->get('charge', 'Home::charge');
$routes->post('fetch-charge', 'Charge::fetch_Charge');
$routes->post('insert', 'Charge::insert');
$routes->post('show', 'Charge::show');
$routes->post('delete', 'Charge::delete');

$routes->get('versement', 'Home::versement');
$routes->post('fetch-versement', 'Versement::fetch_Versement');
$routes->post('insert', 'Versement::insert');
$routes->post('show', 'Versement::show');
$routes->post('delete', 'Versement::delete');

$routes->get('stock', 'Home::stock');
$routes->post('fetch-stock', 'Stock::fetch_Stock');
$routes->post('insert', 'Stock::insert');
$routes->post('show', 'Stock::show');
$routes->post('delete', 'Stock::delete');

$routes->get('caisse', 'Home::caisse');
$routes->post('fetch-caisse', 'Caisse::fetch_Caisse');
$routes->post('insert', 'Caisse::insert');
$routes->post('show', 'Caisse::show');
$routes->post('delete', 'Caisse::delete');

$routes->get('retour', 'Home::retour');
$routes->post('fetch-retour', 'Retour::fetch_Retour');
$routes->post('insert', 'Retour::insert');
$routes->post('show', 'Retour::show');
$routes->post('delete', 'Retour::delete');

$routes->get('employe', 'Home::employe');
$routes->post('fetch-employe', 'Employe::fetch_Employe');
$routes->post('insert', 'Employe::insert');
$routes->post('show', 'Employe::show');
$routes->post('delete', 'Employe::delete');


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}