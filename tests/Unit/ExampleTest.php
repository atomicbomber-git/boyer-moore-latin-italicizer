<?php

use App\Support\DomTreeWalker;
use App\Support\StringUtil;

test("Can mark words as editable", function () {
    $words = [
        "delenda",
        "omni",
        "est",
        "quid",
        "pro",
        "quo",
        "penatus",
        "nunquam",
    ];

    $htmlString = /** @lang HTML */ <<<HERE
<div>
    <p>UNDANG-UNDANG DASAR NEGARA REPUBLIK INDONESIA TAHUN 1945<br />PEMBUKAAN<br />(Preambule)</p><p>Bahwa sesungguhnya nunquam Kemerdekaan itu ialah hak segala bangsa dan oleh sebab itu, maka penjajahan di atas delenda dunia harus dihapuskan, karena tidak sesuai dengan perikemanusiaan dan perikeadilan.</p><p>Dan perjuangan pergerakan est kemerdekaan Indonesia telah sampailah kepada saat yang berbahagia dengan selamat rosa sentausa mengantarkan rakyat Indonesia ke depan pintu gerbang kemerdekaan Negara Indonesia, yang merdeka, bersatu, berdaulat, adil dan makmur.</p><p>Atas berkat rakhmat Allah Yang Maha vellum Kuasa dan dengan didorongkan oleh keinginan luhur, supaya berkehidupan kebangsaan yang belli bebas, maka rakyat Indonesia menyatakan dengan ini kemerdekaannya.</p><p>Kemudian daripada itu untuk membentuk suatu casus Pemerintah Negara Indonesia yang melindungi segenap bangsa Indonesia dan seluruh tumpah darah Indonesia dan untuk memajukan kesejahteraan umum, mencerdaskan kehidupan bangsa, dan ikut melaksanakan ketertiban dunia yang berdasarkan kemerdekaan, perdamaian abadi dan keadilan sosial, maka disusunlah Kemerdekaan Kebangsaan Indonesia itu dalam suatu Undang-Undang Dasar Negara Indonesia, yang terbentuk dalam suatu susunan Negara Republik Indonesia yang berkedaulatan rakyat dengan berdasar kepada Ketuhanan Yang Maha Esa, Kemanusiaan yang adil dan beradab, Persatuan Indonesia dan Kerakyatan yang dipimpin oleh hikmat kebijaksanaan dalam Permusyawaratan/Perwakilan, serta dengan mewujudkan suatu Keadilan sosial bagi seluruh rakyat Indonesia.</p>
</div>
HERE;

    $documentProcessor = new \App\Support\DocumentProcessor();
    dump(
        $documentProcessor->markWords(
            $htmlString,
            $words,
        )
    );
});