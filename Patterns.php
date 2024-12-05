<?php
// Singleton
// Патерн Singleton гарантує, що клас має лише один екземпляр і забезпечує глобальний доступ до нього.
class Singleton {
    private static $instance;

    private function __construct() { }
    private function __clone() { }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Singleton();
        }
        return self::$instance;
    }
}

// Використання:
$singleton = Singleton::getInstance();

// ====================================================================================================================

// Factory Method
// Factory Method дозволяє створювати об'єкти без вказівки точного класу, використовуючи інтерфейс або абстрактний клас.
interface Product {
    public function getName();
}

class ConcreteProductA implements Product {
    public function getName() {
        return "Product A";
    }
}

class ConcreteProductB implements Product {
    public function getName() {
        return "Product B";
    }
}

abstract class Creator {
    abstract public function factoryMethod();
}

class ConcreteCreatorA extends Creator {
    public function factoryMethod() {
        return new ConcreteProductA();
    }
}

class ConcreteCreatorB extends Creator {
    public function factoryMethod() {
        return new ConcreteProductB();
    }
}

// Використання:
$creatorA = new ConcreteCreatorA();
$productA = $creatorA->factoryMethod();
echo $productA->getName();  // Output: Product A

// ====================================================================================================================

// Observer
// Патерн Observer дозволяє одному об'єкту спостерігати за змінами іншого об'єкта.
interface Observer {
    public function update($message);
}

class ConcreteObserver implements Observer {
    public function update($message) {
        echo "Received message: $message\n";
    }
}

class Subject {
    private $observers = [];

    public function addObserver(Observer $observer) {
        $this->observers[] = $observer;
    }

    public function notifyObservers($message) {
        foreach ($this->observers as $observer) {
            $observer->update($message);
        }
    }
}

// Використання:
$subject = new Subject();
$observer = new ConcreteObserver();
$subject->addObserver($observer);
$subject->notifyObservers("Hello, Observers!");

// ====================================================================================================================

// Decorator
// Патерн Decorator дозволяє динамічно додавати функціональність об'єкту.
interface Component {
    public function operation();
}

class ConcreteComponent implements Component {
    public function operation() {
        return "ConcreteComponent";
    }
}

class Decorator implements Component {
    protected $component;

    public function __construct(Component $component) {
        $this->component = $component;
    }

    public function operation() {
        return $this->component->operation();
    }
}

class ConcreteDecorator extends Decorator {
    public function operation() {
        return "ConcreteDecorator(" . parent::operation() . ")";
    }
}

// Використання:
$component = new ConcreteComponent();
$decorated = new ConcreteDecorator($component);
echo $decorated->operation();  // Output: ConcreteDecorator(ConcreteComponent);

// ====================================================================================================================

// Strategy
// Патерн Strategy дозволяє змінювати поведінку об'єкта під час виконання, вибираючи одну з множини стратегій.
interface Strategy {
    public function execute($a, $b);
}

class AddStrategy implements Strategy {
    public function execute($a, $b) {
        return $a + $b;
    }
}

class SubtractStrategy implements Strategy {
    public function execute($a, $b) {
        return $a - $b;
    }
}

class Context {
    private $strategy;

    public function __construct(Strategy $strategy) {
        $this->strategy = $strategy;
    }

    public function setStrategy(Strategy $strategy) {
        $this->strategy = $strategy;
    }

    public function executeStrategy($a, $b) {
        return $this->strategy->execute($a, $b);
    }
}

// Використання:
$context = new Context(new AddStrategy());
echo $context->executeStrategy(5, 3);  // Output: 8
$context->setStrategy(new SubtractStrategy());
echo $context->executeStrategy(5, 3);  // Output: 2
