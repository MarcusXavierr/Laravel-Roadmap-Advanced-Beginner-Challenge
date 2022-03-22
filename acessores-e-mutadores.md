# Pra que servem?
Acessores, mutadores e attribute casting te permitem transformar atributos eloquent na hora de retornar seus valores ou setar eles em novas intancias do model.
Por exemplo, tu pode usar o laravel encrypter pra encriptar um valor na hora de salvar no banco de dados, e automaticamente decriptar quando tu recuperar esses valores. 

# Acessores e mutadores
## Criando um acessor
Um acessor transforma um atributo na hora que você acessa ele (faz o get). Pra definir um, crie um metodo protegido que vai representar o atributo acessivel. O nome precisa ser a versão camelCase do nome verdadeiro do atributo no banco de dados.
Todos os métodos acessores precisam retornar um tipo de `Attribute`

```php
class User extends Model
{
    /**
     * Get the user's first name.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function firstName(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucfirst($value),
        );
    }
}
```

Essa classe Attribute vai ditar como o atributo será acessado e, opcionalmente, alterado.

## Definindo um mutador
Um mutador transforma o eloquent attribute na hora de setar o valor. Por isso pra usar isso você precisa passar uma função pro parametro `set` do metodo `make()`.

Exemplo
```php
class User extends Model
{
    /**
     * Interact with the user's first name.
     *
     * @param  string  $value
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function firstName(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucfirst($value),
            set: fn ($value) => strtolower($value),
        );
    }
}
```