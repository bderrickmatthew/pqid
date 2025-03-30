<?php

namespace Seraph;

interface Website
{
    public function getDefaultRoute(): string;
    public function getController(string $controllerName): ?object;
}