# Laravel Form Helpers 

Een set van blade directieves dat automatisch formulieren kan vullen doormiddel van [oude inputs](https://laravel.com/docs/5.7/requests#old-input)
of een [Eloquent](https://laravel.com/docs/5.7/eloquent) model instantie, het helpt je ook om [validatie foutmeldingen](https://laravel.com/docs/5.7/validation#working-with-error-messages) een mooie + gemakkelijke weg weer te geven.

## Voorbeeld 
Zie hier hoe gemakkelijk het is om daadwerkelijk bepaalde dingen te doen in je applicatie met deze directives, bijvoorbeeld
als je Bootstrap 4 gebruikt als frontend framework. Kan je het volgende doen: 

```html 
<form action="/users" method="POST">
    @form($model)

    <div class="form-group">
        <input type="text" class="form-control @error('naam', 'is-invalid')"> @input('naam')
        @error('naam')
    </div>
</form>
```

En in geval dat de gebruiker word terug geleid door de nodige validatie foutmelding, resulteerd dat in de volgende markup:

```html
<form action="/users" method="POST">
    <div class="form-group">
        <input type="text" class="form-control is-invalid" value="Slechte naam">
        <div class="invalid-feedback">Foutmelding</div>
    </div>
</form>
```

## Installatie 

Installeer de package met de composer package manager. Juist door heel simpel het volgende commando te laten lopen in je CLI: 

```bash
composer require vp/laravel-form-helpers
```

Meer dan dit is het niet. 

## Confguratie 

**Optioneel:** Als de configuratie van de package wenst aan te passen kun je het volgende commando gebruiken voor het verkrijgen van het config bestand; 

```bash
php artisan vendor:publish --provider=VerhuurPlatform\Form\FormServiceProvider
```

Achter dat kun je beginnen met je aanpassingen door te voeren in de `config/form-helpers.php` file. 

## Gebruik 

### @form

`@form([Model $model = null])`

Gebruik de optionele `@form` directive voor het koppelen van Eloquent data aan je formulier. 
Negeer deze directive als je alleen de eerder gegegeven data van het formulier wilt gebruiken. 

```html
<form action="/users/123" method="POST">
    @form($user)
</form>
```

### @input 

`@input(string $attribute, [string $default = null])`

Gebruik de `@input` directive voor het koppelen van een waarde aan een invoer veld: 

```html
<input type="text" @input('naam')>
<input type="text" @input('email', 'test@domein.be')>
```

Dit zal resulteren in de volgende HTML code: 

```html
<input type="text" name="naam" value="">
<input type="text" name="email" value="test@domein.be">
```

### @text 

`@text(string $attribute, [string $default = null])`

Gebruik de `@text` directive voor het koppen van een waarde aan textgebied veld: 

```html
<textarea name="beschrijving">@text('beschrijving')</textarea>
<textarea name="beschrijving">@text('beschrijving', 'Standaard beschrijving')</textarea>
```

Dit zal resulteren in de volgende HTML code: 

```html
<textarea name="beschrijving"></textarea>
<textarea name="beschrijving">Standaard waarde</textarea>
```

### @checkbox

`@checkbox(string, [mixed $value = 1, [boolean $checked = false]])`

Gebruik de `@checkbox` directive om een waarde en status aan de checkbox te koppelen.

```html 
<input type="checkbox" @checkbox('remember_me')>

<!-- Aangepaste value -->
<input type="checkbox" @checkbox('nieuwsbrief', 'ja')>

<!-- Activeer de checkbox als standaard -->
<input type="checkbox" @checkbox('zend_sms', 1, true)>
```

Dit zal resulteren in de volgende HTML code: 

```html 
<input type="checkbox" name="remember_me" value="1">

<!-- Aangepaste value -->
<input type="checkbox" name="nieuwsbrief" value="ja">

<!-- Activeer de checkbox als standaard -->
<input type="checkbox" name="zend_sms", value="1" checked>
```

### @radio

`@radio(string $attribute, [mixed $value = 1, [boolean $checked = false]])`

Gebruik de `@radio` directive om een waarde en status aan een radio button te koppelen.

```html 
<input type="radio" @radio('kleur', 'rood')>
<input type="radio" @radio('kleur', 'groen', true)>
<input type="radio" @radio('kleur', 'blauw')>
```

Dit zal resulteren in de volgende HTML code: 

```html 
<input type="radio" name="kleur" value="rood">
<input type="radio" name="kleur" value="groen" checked>
<input type="radio" name="kleur" value="blauw">
```

### @options

`@options(array $options, string $attribute, [mixed $default = null, [string $placeholder = null]])`

Gebruik de `@options` directive voor het weergeven en koppelen van de lijst met opties voor een select veld.

*Info:* Deze directive werkt ook met een **multiple select** wanneer het model attribute, oude invoer of de standaard waarde
een array zijn. 

Laten we zeggen dat we een array in de directive gebruiken genaamd `$cardTypes` in het voorbeeld.

```php 
$cardTypes = [
    'VISA' => 'Visa', 
    'MC'   => 'Master Card',
    'AME'  => 'American Express', 
];
```

```html 
<select name="kaart_type">
    @options($cartTypes, 'kaart_type')
</select>
```

Dit zal resulteren in de volgende HTML code:

```html 
<select name="kaart_type">
    <option value="VISA">Visa</option>
    <option value="MC">Master Card</option>
    <option value="AME">American Express</option>
</select>
```

Je kunt ook een *placceholder* definieren: 

```html
<select name="kaart_type">
    @options($cardTypes, 'kaart_type', null, 'Selecteer een kaart type')
</select>
```

Dit zal resulteren in de volgende HTML code: 

```html
<select name="card_type">
    <option value="" selected disabled>Select a card type</option>
    <option value="VISA">Visa</option>
    <option value="MC">Master Card</option>
    <option value="AME">American Express</option>
</select>
```

### @error

`@error(string $attribute, [string $template = null])`

gebruik de `@error` directive. voor het weergeven van een validate foutmelding, Deze directive zal checken dat de foutmelding 
wel degelijk bestaat of niet. 

```html
<input type="text" @input('naam')>
@error('naam')
```

Wanneer de gebruiker is terug geleid naar de vorige pagine met de nodige foutmeldingen, zal het resultaat er al volgende uitzien: 

```html
<input type="text" class="form-control is-invalid" name="naam" value="Naam dat foutmeldingen geeft">
<div class="invalid-feedback">Het naam veld heeft foutmeldingen</div>
```

**Note:** Dat de `@error` directive standaard [Bootstrap](https://getbootstrap.com/) gebruikt als CSS framework, 
maar je kunt een aangepaste CSS class gebruiken inline of meegeven bij het aanpassen van het configuratie bestand. 

**Voorbeeld:**

```
@error('naam', '<div class="error">:message</span>')
```

Wat de volgende HTML code genereerd: 

```html
<div class="error">Foutmelding</div>
```

Zie hoe gemakkelijk het is om coole dingen te doen met `@error´ directive, bijvoorbeeld als je [Bootstrap](https://getbootstrap.com/) gebruikt voor je markup, dan kun je zoiets als dit doen:

```html
<div class="form-group">
    <input type="text" class="form-control @error('naam', 'is-invalid')" @input('naam')>
    @error('naam')
</div>
```


En in het geval dat de gebruiker teruggestuurd wordt met fouten, zal het resultaat zijn:

```html
<div class="form-group">
    <input type="text" class="form-control is-invalid" name="naam" value="Slechte naam">
    <div class="invalid-feedback">Foutmelding</div>
</div>
```
