<?php

namespace App\Views;

class Home extends View
{
    public function authForm(): static
    {
        $title = 'Login';
        $body = <<<HTML
        <form method="POST" action="/home/login">
        Enter user name: <br>
        <input type="text" name="user" /><br>
        Enter password: <br>
        <input type="password" name="password" /><br>
        <input type="submit" value="Enter" />
        </form>
        HTML;
        $this->replacements = [
            '{{{title}}}' => $title,
            '{{{body}}}' => $body
        ];
        return $this;
    }

    public function home(): static
    {
        $title = 'Home';
        $body = <<<HTML
        <div>Hello, {$_SESSION['login']}</div>
        <br />
        <a href="/home?action=out">Exit</a>
        HTML;
        $this->replacements = [
            '{{{title}}}' => $title,
            '{{{body}}}' => $body
        ];
        return $this;
    }

    public function error(array $message, string $route, string $linkName): static
    {
        $title = 'Error';
        $body = <<<HTML
        <h2>Error was occured:</h2>
        HTML;
        foreach ($message as $item) {
            $body .= '<p>' . $item . '</p>';
        }
        $body .= <<<HTML
        <p></p>
        <br />
        <a href="$route">$linkName</a>
        HTML;
        $this->replacements = [
            '{{{title}}}' => $title,
            '{{{body}}}' => $body
        ];
        return $this;
    }
}
