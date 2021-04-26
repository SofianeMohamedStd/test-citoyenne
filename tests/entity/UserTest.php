<?php
namespace App\Tests\entity;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
{

    private $validator;

    protected function setUp(): void
    {

        $kernel = self::bootKernel();
        $kernel->boot();
        $this->validator = $kernel->getContainer()->get("validator");
    }

    public function testInstanceOf()
    {
        $user = new User();
        $this->assertInstanceOf(User::class, $user);
        $this->assertClassHasAttribute("firstname",User::class);
        $this->assertClassHasAttribute("lastname",User::class);
        $this->assertClassHasAttribute("email",User::class);
        $this->assertClassHasAttribute("password",User::class);
        $this->assertClassHasAttribute("phone",User::class);
    }

    /**
     * @dataProvider ProviderInvalidEmail
     * @param $email
     */
    public function testInvalidEmail($email)
    {
        $user = new User();

        $user->setEmail($email);
        $errors = $this->validator->validate($user);
        $this->assertGreaterThanOrEqual(1, count($errors));
    }

    public function ProviderInvalidEmail(): array
    {
        return [
            [""],
            ["namoune@"],
            ["namoune@gmailcom"],
            ["namoune.mohamedSofiane"]
        ];
    }

    /**
     * @dataProvider ProviderValidEmail
     * @param $email
     */
    public function testValidEmail($email)
    {
        $user = new User();

        $user->setEmail($email);
        $errors = $this->validator->validate($user);
        $this->assertCount(2, $errors);
    }

    public function ProviderValidEmail(): array
    {
        return [
            ["namoune@gmail.com"]
        ];
    }

    /**
     * @param $firstname
     * @dataProvider provideInvalidFirstnameValues
     */
    public function testInvalideFirstnameProperty($firstname)
    {

        $user = new User();
        $user->setFirstname($firstname);
        $errors = $this->validator->validate($user);
        $this->assertGreaterThanOrEqual(1, count($errors));
    }

    public function provideInvalidFirstnameValues()
    {
        return [
            ['sissouf1'],
            [''],
            ['namoune_'],
            ['mohammed sofiane']
        ];
    }

    /**
     * @param $firstname
     * @dataProvider provideValidFirstnameValues
     */
    public function testValidFirstnameProperty($firstname)
    {

        $user = new User();
        $user->setFirstname($firstname);
        $errors = $this->validator->validate($user);
        $this->assertEquals(2, count($errors));
    }

    public function provideValidFirstnameValues(): array
    {
        return [
            ['sofiane'],
            ['MOHAMMED'],
            ['mohamed-sofiane'],
        ];
    }

    /**
     * @dataProvider ProviderInvalidPhone
     * @param $phone
     */
    public function testInvalidPhone($phone)
    {
        $user = new User();

        $user->setPhone($phone);
        $errors = $this->validator->validate($user);
        $this->assertGreaterThanOrEqual(1, count($errors));
    }

    public function ProviderInvalidPhone(): array
    {
        return [
            [""],
            ["02245"],
            ["545484"],
            ["00015151651651651651"]
        ];
    }

    /**
     * @dataProvider ProviderValidPhone
     * @param $phone
     */
    public function testValidPhone($phone)
    {
        $user = new User();

        $user->setPhone($phone);
        $errors = $this->validator->validate($user);
        $this->assertCount(3, $errors);
    }

    public function ProviderValidPhone(): array
    {
        return [
            ["0752796749"],
            ["+33752796749"],
        ];
    }

}