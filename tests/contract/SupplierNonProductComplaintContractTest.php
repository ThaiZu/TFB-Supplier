<?php

declare(strict_types=1);

function supplierComplaintAssert(bool $condition, string $message): void
{
    if (!$condition) {
        fwrite(STDERR, "FAIL: {$message}\n");
        exit(1);
    }
}

$view = file_get_contents(__DIR__ . '/../../src/app/Views/complaints/index.twig');

supplierComplaintAssert(
    str_contains($view, "complaint_type:      {{ (complaint.complaint_type ?? 'PRODUCT')|json_encode|raw }}"),
    'Widok dostawcy nie przekazuje typu reklamacji do JavaScript.'
);
supplierComplaintAssert(
    str_contains($view, "const isNonProduct = c.complaint_type === 'NON_PRODUCT';"),
    'Widok dostawcy nie rozróżnia reklamacji nieproduktowej.'
);
supplierComplaintAssert(
    str_contains($view, 'translations.complaints_non_product') && str_contains($view, 'non_product:'),
    'Widok dostawcy nie używa tłumaczenia dla reklamacji nieproduktowej.'
);
supplierComplaintAssert(
    (bool) preg_match('/if \(!isNonProduct\) \{\s+payload\.accepted_qty = qty;\s+\}/', $view),
    'Widok dostawcy nadal wysyła accepted_qty dla reklamacji nieproduktowej.'
);
supplierComplaintAssert(
    str_contains($view, 'value="CORRECTIVE_ACTION"')
        && str_contains($view, 'value="NO_COMPENSATION"')
        && str_contains($view, 'isNonProduct ?'),
    'Widok dostawcy nie ogranicza sposobów rozpatrzenia reklamacji nieproduktowej.'
);

echo "Supplier non-product complaint contract: OK\n";
