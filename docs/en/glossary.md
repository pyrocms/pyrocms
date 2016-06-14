# Glossary

<ul class="list-inline">
{% for letter in 'a'|upper..'z'|upper %}
    <li>
        <a href="#{{ letter }}">{{ letter }}</a>
    </li>
{% endfor %}
</ul>

<hr>

<a name="A"></a>
## A

#### Addon

An addon is a composer-like package of code that adds functionality to your project. Pyro supports `extension`, `field_type`, `module`, `plugin`, and `theme` addon types.

#### Application

The application is your website or product using Pyro.

#### Application Reference

The application reference is a unique slug that identifies an application from others within the same Pyro installation.

#### Asset

An asset is a `js`, `css`, or otherwise theme asset that is managed with the `\Anomaly\Streams\Platform\Asset\Asset` service. The asset service supports a wide variety of features for manipulating and presenting all kinds of assets.

#### Assignment

An assignment is the relation between a Stream and a Field.

<hr>

<a name="B"></a>
## B

#### Builder

Builders are simple classes that contain definitions for building complex components. Builders are typically found in the UI namespace but the pattern can be used anywhere.

<hr>

<a name="C"></a>
## C

#### Callback

The `\Anomaly\Streams\Platform\Traits\FiresCallbacks` trait allows you to register and fire callback methods on an object. Callbacks are similar to events but are localized to the object in question.

#### Collection

Collections in Pyro work just like collections in Laravel, with some added functionality. Collections typically live within addons directly next to the model they are used with but can be used just the same as in Laravel.

#### Command

Commands in Pyro work just like commands in Laravel, with the exception that handlers live in the same directory as commands (if not `SelfHandling`). Commands typically live within addons but can be used just the same as in Laravel.

#### Controller

Controllers in Pyro work just like controllers in Laravel, with some added functionality. Controllers typically live within addons but can be used just the same as in Laravel.

#### Criteria

Model criteria extends the plugin API of a model when fetching model results.

    {% verbatim %}{{ entries("store", "products").example("foo").get() }}{% endverbatim %}

<hr>

<a name="D"></a>
## D

#### Definition

Definitions simple strings, arrays, closures, or handlers that describe larger components. Definitions usually describe a control panel or UI component but can also describe fields, field types, streams and more. Pyro converts definitions into objects.

    // Table columns definition
    protected $columns = [
        "title",
        "description"
    ];

<hr>

<a name="E"></a>
## E

#### Entry

Entries are simply the database records in a stream. All entries belong to a stream. All entries are made of fields that are assigned to it's stream.

#### Evaluator

The `\Anomaly\Streams\Platform\Support\Evaluator` utility helps resolve a value from an instance of a `Closure`. The evaluator calls the closure through Laravel's service container.

    $value = $evaluator->evaluator($closure, $arguments);

#### Extension

Extensions are an a "wild card" addon type. They let developers build addons and applications that are closed for modification and open for **extension**.

<hr>

<a name="F"></a>
## F

#### Field

A field is the relation between a field type and a unique configuration of said field type.

#### Field Type

Field types (FTs) are addons that make up the foundation of your entire application's UI and schema. They provide inputs, build database schema and more.

#### Form

Forms are a UI component that help you effortlessly display forms for creating and editing stream entries.

<hr>

<a name="H"></a>
## H

#### Handler

Handlers are classes that handle more complex logic for something else. Handlers are often used for control panel or UI definitions but can be used for anything that runs through Pyro's `Resolver` service.

    // Table columns definition handler
    protected $columns = "Example\Table\TableColumns@handle";

<hr>

<a name="I"></a>
## I

#### Image

Images are typically managed with the `\Anomaly\Streams\Platform\Image\Image` service. The image service supports a wide variety of features for manipulating your image and it's presentation.

<hr>

<a name="M"></a>
## M

#### Mailer

The mailer in Pyro works just like the mailer in Laravel, with some added functionality. The Pyro mailer supports translatable messages but can be used just the same as in Laravel.

#### Message

The `\Anomaly\Streams\Platform\Message\MessageBag` stashes string messages in the session that are used to display alert / info type messages to the user.

    $messages->info("Heads up!");

#### Middleware

Middleware in Pyro works just like middleware in Laravel. Middleware typically lives within an addon but can be used just the same as in Laravel.

#### Migration

Migrations in Pyro work just like migrations in Laravel, with some added functionality. Migrations typically live within addons but can be used just the same as in Laravel.

#### Module

Modules are addons that make up the primary building blocks of an application.

<hr>

<a name="O"></a>
## O

#### Observer

Observers in Pyro work just like observers in Laravel, with some added functionality. Observers typically live within addons directly next to the model they observe but can be used just the same as in Laravel.

<hr>

<a name="P"></a>
## P

#### Parse

Parsing a value returns the string output after parsing with the Twig engine.

#### Plugin

Plugins are addons that act essentially as [Twig extensions](http://twig.sensiolabs.org/doc/advanced.html). They help extend functionality within the view layer.

#### Presenter

Presenters extend the entry with logic typically used in the view layer (or presentation layer).

    {% verbatim %}{{ products.label("sale") }} // &lt;span class="label label-success">On Sale!&lt;/span>{% endverbatim %}

<hr>

<a name="R"></a>
## R

#### Repository

Repositories are an _optional_ programming pattern used heavily in Pyro that help separate your entity logic from your database logic.

#### Resolver

The `\Anomaly\Streams\Platform\Support\Resolver` utility helps resolve a value from callable strings like `Example\Table\TableColumns@handle`. The resolver calls the handler through Laravel's service container.

    $value = $resolver->resolver($handler, $arguments);

#### Route

Routes in Pyro work just like routes in Laravel, with some added functionality. Routes typically live in an addon's service provider but can be used just the same as in Laravel.

<hr>

<a name="S"></a>
## S

#### Seeder

Seeders in Pyro work just like seeders in Laravel, with some added functionality. Seeders typically live within addons but can be used just the same as in Laravel.

#### Service Provider

Service providers in Pyro work just like service providers in Laravel, with some added functionality. Service providers typically live within addons but can be used just the same as in Laravel.

#### Stream

A Stream is simply a structure of data that you can entries in. Anything can be defined by a stream. For example, you could create a stream for Products and assign fields to it like a name, category, price, and description.

<hr>

<a name="T"></a>
## T

#### Table

Tables are a UI component that help you effortlessly display stream entries in simple or complex tables.

#### Template Data

The `\Anomaly\Streams\Platform\View\ViewTemplate` is a collection of data that is set as a global variable in the view layer.

    $template->set("meta_title", "Hello World"); // {% verbatim %}{{ template.meta_title }}{% endverbatim %}

#### Theme

Themes the addons that are responsible for displaying the control panel and the public facing site.

#### Translator

The translation service in Pyro works just like translator in Laravel, with some added functionality.

#### Tree

Trees are a UI component that help you effortlessly display nestable stream entries in a sortable list.

<hr>

<a name="V"></a>
## V

#### Value String

Value strings are dot notated strings passed through the `\Anomaly\Streams\Platform\Support\Value` utility to resolve an entry, object, or array value.

    echo $value->make("entry.name", $entry);        // Juliet
    echo $value->make("entry.parent.name", $entry); // Ryan

#### View

Views in Pyro work just like views in Laravel with the exception that Twig is the default template engine. View's typically live within an addon but can be used anywhere in your application.
