<?php declare(strict_types=1);

function cv17h(string $value): string
{
  return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

class Cv17Student
{
  private string $note = '';

  public function __construct(public string $name, public int $year)
  {
  }

  public function greeting(): string
  {
    return "Ahoj, já jsem {$this->name} a chodím do {$this->year}. ročníku.";
  }

  public function setNote(string $note): void
  {
    $this->note = $note;
  }

  public function getNote(): string
  {
    return $this->note;
  }
}

class Cv17BankAccount
{
  private float $balance = 0;

  public function deposit(float $amount): void
  {
    if ($amount > 0) {
      $this->balance += $amount;
    }
  }

  public function getBalance(): float
  {
    return $this->balance;
  }
}

class Cv17Animal
{
  public function sound(): string
  {
    return "nějaký zvuk";
  }
}

class Cv17Cat extends Cv17Animal
{
  public function sound(): string
  {
    return "mňau";
  }
}

class Cv17Car
{
  public function __construct(public string $brand)
  {
  }
}

class Cv17SportCar extends Cv17Car
{
  public function description(): string
  {
    return "Sportovní auto značky {$this->brand}";
  }
}

class Cv17Counter
{
  private int $count = 0;

  public function call(): int
  {
    $this->count++;
    return $this->count;
  }
}

class Cv17User
{
  private string $password = '';

  public function setPassword(string $password): bool
  {
    if (mb_strlen($password) < 6) {
      return false;
    }

    $this->password = $password;
    return true;
  }

  public function hasPassword(): bool
  {
    return $this->password !== '';
  }
}

class Cv17Database
{
  public function connect(): ?PDO
  {
    return lessonDbPdo();
  }
}

class Cv17Form
{
  public function __construct(public string $action, public string $method, public string $label)
  {
  }
}

class Cv17Renderer
{
  public function render(array $items): string
  {
    $html = '<ul>';
    foreach ($items as $item) {
      $html .= '<li>' . cv17h((string) $item) . '</li>';
    }
    return $html . '</ul>';
  }
}

class Cv17Product
{
  public function __construct(public string $name, public float $price)
  {
  }

  public function display(): string
  {
    return cv17h($this->name) . ' - ' . number_format($this->price, 2, ',', ' ') . ' Kč';
  }
}
?>

<h2 class="subtitle">Cvičení 17.1</h2>

<?php
$student = new Cv17Student('Eva', 2);
echo "Třída Student má vlastnosti jméno: " . cv17h($student->name) . " a ročník: {$student->year}.";
?>

<h2 class="subtitle">Cvičení 17.2</h2>

<?php
$students = [new Cv17Student('Eva', 2), new Cv17Student('Karel', 3)];
foreach ($students as $item) {
  echo cv17h($item->name) . " ({$item->year}. ročník)<br>";
}
?>

<h2 class="subtitle">Cvičení 17.3</h2>

<p><?= cv17h($student->greeting()) ?></p>

<h2 class="subtitle">Cvičení 17.4</h2>

<?php
$constructedStudent = new Cv17Student('Jana', 4);
echo cv17h($constructedStudent->greeting());
?>

<h2 class="subtitle">Cvičení 17.5</h2>

<?php
$student->setNote('Soukromá poznámka');
echo "Private vlastnost note byla nastavena metodou setNote().";
?>

<h2 class="subtitle">Cvičení 17.6</h2>

<p>Getter vrátil: <?= cv17h($student->getNote()) ?></p>

<h2 class="subtitle">Cvičení 17.7</h2>

<?php
$account = new Cv17BankAccount();
$account->deposit(500);
$account->deposit(250);
echo "Zůstatek: " . number_format($account->getBalance(), 2, ',', ' ') . " Kč";
?>

<h2 class="subtitle">Cvičení 17.8</h2>

<?php
$cat = new Cv17Cat();
echo "Kočka dělá: " . cv17h($cat->sound());
?>

<h2 class="subtitle">Cvičení 17.9</h2>

<?php
$sportCar = new Cv17SportCar('Škoda');
echo cv17h($sportCar->description());
?>

<h2 class="subtitle">Cvičení 17.10</h2>

<?php
$counter = new Cv17Counter();
echo "Volání: " . $counter->call() . ", " . $counter->call() . ", " . $counter->call();
?>

<h2 class="subtitle">Cvičení 17.11</h2>

<?php
$user = new Cv17User();
echo $user->setPassword('tajne') ? "Heslo uloženo." : "Heslo je příliš krátké.";
echo "<br>";
echo $user->setPassword('tajne123') ? "Druhé heslo uloženo." : "Druhé heslo je příliš krátké.";
?>

<h2 class="subtitle">Cvičení 17.12</h2>

<?php
$database = new Cv17Database();
echo $database->connect() ? "Database::connect() vrátila PDO připojení." : "PDO připojení není dostupné mimo Docker.";
?>

<h2 class="subtitle">Cvičení 17.13</h2>

<?php
$form = new Cv17Form('/lesson17', 'POST', 'Odeslat');
echo "Formulář: action=" . cv17h($form->action) . ", method=" . cv17h($form->method) . ", label=" . cv17h($form->label);
?>

<h2 class="subtitle">Cvičení 17.14</h2>

<?php
$renderer = new Cv17Renderer();
echo $renderer->render(['PHP', 'OOP', 'PDO']);
?>

<h2 class="subtitle">Cvičení 17.15</h2>

<?php
$product = new Cv17Product('Učebnice PHP', 420);
echo $product->display();
?>
