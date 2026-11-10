#!/bin/bash

# Same audits as the CI. A finding must not stop "ddev start".
composer ci:node:audit || true
composer ci:composer:audit || true
