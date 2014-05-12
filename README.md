# Dynamic subdomain handler for Symfony 2

## Install

In `composer.json`:

```json
"require": {
    "netgusto/dynamic-subdomain-bundle": "dev-master"
}
```

In `app/AppKernel.php`:

```php
$bundles = array(
    # [...]
    new Netgusto\DynamicSubdomainBundle\NetgustoDynamicSubdomainBundle(),
    # [...]
);
```

## Configure

In app/config.yaml

```yaml
netgusto_dynamic_subdomain:
    base_host: netgusto.com
    parameter_name: ~
    entity: Acme\DemoBundle\Entity\MySite
    property: ~
```

* `base_host`:

    * The domain base host, where all subdomains are attached
    * **required**
    * example: `netgusto.com`

* `parameter_name`:

    * The name of the parameter that will be set on the current `Request`
    * **optional**
    * default value: `subdomain`

* `entity`:
    
    * The class or Doctrine alias of the entity mapped to subdomains
    * **required**
    * example: `Acme\DemoBundle\Entity\MySite`

* `property`:
    
    * The name of the property storing the subdomain name in your entity
    * **optional**
    * default value: `subdomain`

## Use

1. Create the entities mapped to your subdomains
2. Get the current subdomain object through the Symfony `Request` object

In php, assuming that `netgusto_dynamic_subdomain.property` equals `subdomain` (the default value):

```php
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {

    public function indexAction(Request $request) {
        $subdomainobject = $request->request->get('subdomain');
        var_dump($subdomainobject);
    }

```

In twig, assuming that `netgusto_dynamic_subdomain.property` equals `subdomain` (the default value), and that the entity mapped to subdomains has a `title` property:

```twig
{{ app.request.get('subdomain').title }}
```

## Notes

If the subdomain is not found in the database, an exception will be thrown by the Bundle (`Symfony\Component\HttpKernel\Exception\NotFoundHttpException`).
