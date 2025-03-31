<?php

namespace App\Controllers;

use Seraph\DatabaseTable;

class Author
{
    /**
     * Class constructor.
     */
    public function __construct(private DatabaseTable $authorsTable)
    {

    }

    public function registrationForm(): array
    {
        return [
            'template' => 'register.html.php',
            'title' => 'Register an account'
        ];
    }

    public function success(): array
    {
        return [
            'template' => 'registersuccess.html.php',
            'title' => 'Registration successful'
        ];
    }

    public function registrationFormSubmit()
    {
        $author = $_POST['author'];

        // start with an empty array
        $errors = [];

        // check for name
        if (empty($author['name'])) {
            $errors[] = 'Name cannot be blank';
        }

        // check the email
        if (empty($author['email'])) {
            $errors[] = 'Email cannot be blank';
        } elseif (filter_var(value: $author['email'], filter: FILTER_VALIDATE_EMAIL) == false) {
            $errors[] = 'Invalid email address';
        } else {
            // if the email is not blank and not valid, convert email to lowercase
            $author['email'] = strtolower(string: $author['email']);
        }

        // search for the lowercase version of $author['email']
        if (count($this->authorsTable->find(field: 'email', value: $author['email'])) > 0) {
            $errors[] = 'That email is already registered';
        }


        // check the password
        if (empty($author['password'])) {
            $errors[] = 'Password cannot be blank';
        }

        if (empty($errors)) {
            // hash the password before saving it in the databse
            $author['password'] = password_hash(password: $author['password'], algo: PASSWORD_DEFAULT);

            // When submitted, the $author variable now contains a lowercase value for email
            // and a hashed email
            $this->authorsTable->save(record: $author);

            header('location: /author/success');
        } else {

            // if the data is not valid, show the form again
            return [
                'template' => 'register.html.php',
                'title' => 'Register an account',
                'variables' => [
                    'errors' => $errors,
                    'author' => $author,
                ]
            ];
        }


    }
}