<?php

use App\Support\StringUtil;

test("StringUtil::isWordIn() works perfectly.", function () {
    expect(StringUtil::isWordIn("hello", 0, 3))->toBeFalse();
    expect(StringUtil::isWordIn("hello", 0, 5))->toBeTrue();
    expect(StringUtil::isWordIn("aku iku ita", 0, 3))->toBeTrue();
    expect(StringUtil::isWordIn("aku iku ita", 0, 1))->toBeFalse();
    expect(StringUtil::isWordIn("aku iku ita", 4, 3))->toBeTrue();
    expect(StringUtil::isWordIn("Makan, minum, tidur.", 0, 5))->toBeTrue();
    expect(StringUtil::isWordIn("Makan, minum, tidur.", 0, 6))->toBeTrue();
    expect(StringUtil::isWordIn("Makan, minum, tidur.", 7, 5))->toBeTrue();
    expect(StringUtil::isWordIn("Makan, minum, tidur.", 14, 5))->toBeTrue();
});

