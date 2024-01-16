<?php return array (
  'manifest-version' => '1.1',
  'manifest-attributes' => 
  array (
    'changelog' => '# Список изменений

## 1.3.1-beta (02.08.2022)
 - Исправление ошибок

## 1.3.0-beta4 (27.05.2022)

### Исправлено:

 - сортировка блоков
 - путь для изображения
 - название групп


## 1.3.0-beta3 (27.01.2022)

### Исправлено:

 - ошибки

## 1.3.0-beta2 (25.01.2022)

### Исправлено:

 - ошибка при сохранении блока

## 1.3.0-beta (23.01.2022)

### Добавлено:

 - История блоков

### Изменено:

 - длина текста в блоках

### Исправлено:

 - стили UI


## 1.2.0-beta5 (19.10.2021)

### Исправлено:

 - условие для формирования значений блока и таблицы
 - превью для видео
 - обновление чанка
 - приоритет колеекции
 - загрузка файлов в директорию
 - сохранение столбцов в коллекции
 - сниппет PageBlocks

### Изменено

 - путь загрузки файлов (assets/images/)

## 1.2.0-beta4 (08.10.2021)

### Добавлено:

 - пагинация для полей
 - колонка id для коллекций
 - синхронизация поля published
 - параметры к сниппету PageBlocks

### Исправлено:

 - z-index для окон
 - превью для видео

## 1.2.0-beta3 (07.10.2021)

### Добавлено:

 - параметр object_id к сниппету PageBlocks

## 1.2.0-beta2 (06.10.2021)

### Добавлено:

 - обновление чанка в блоке
 - события:
    - pbBeforeSaveImage
    - pbAfterSaveImage
    - pbBeforeRemoveImage
    - pbAfterRemoveImage
    - pbBeforeSaveBlock
    - pbAfterSaveBlock
    - pbBeforeRemoveBlock
    - pbAfterRemoveBlock

### Исправлено:

 - ошибки

## 1.2.0-beta (01.10.2021)

### Добавлено:

 - вложенность таблиц
 - сниппет PageBlocks
 - управление чанками в конструкторе блоков
 - синхронизация чанка при обновлении блока
 - копирование блоков из ресурса
 - копирование блока по id
 - валидация при загрузки изображения
 - заголовок и описание для картинок галереи
 - переход к ресурсу в коллекции
 - синхронизация полей блока при сохранении ресурса
 - системные настройки:
    - pageblocks_source_path (для загрузки файлов в указанную директорию)
    - pageblocks_remove_image (удаление картинок из файлового источника)
    - pageblocks_create_chunk (создание чанка)
    - pageblocks_remove_chunk (удаление чанка)
    - pageblocks_youtube_api_key (ключ Youtube API)
    - pageblocks_vimeo_api_key (ключ Vimeo API)
    - pageblocks_hide_template (отключение PageBlocks у шаблонов)
    - pageblocks_tab_index (позиция вкладки PageBlocks)
 - описание для полей
 - значение полей в сетку блока
 - рендер для поле ресурс
 - валидация название чанка
 - валидация для названия ключа поля
 - позиция вкладки для коллекций
 - новые поля:
    - Список Да/Нет
    - ACE
    - Видео
    - Видео галерея
    - Логический флажок

### Исправлено:

 - ошибка с копированием коллекции
 - ошибка значение по умолчанию для радиокнопок
 - интеграция табов на страницу ресурса
 - рендер для полей
 - фильтрация полей при группировки
 - сортировка полей
 - сортировка галереи
 - импорт/экспорт

### Изменено:

 - выбор источника и путь загрузки для полей с типом \'Изображение/Галерея/Файл\'
 - лексикон для combo поля

## 1.1.0-beta3 (12.07.2021)

 - Исправлена ошибка с cultureKey

## 1.1.0-beta2 (09.07.2021)

 - Обновлены поля: изображение, файл
 - Новый тип поля: галерея, комбо
 - Добавлен источник файлов для блока
 - Добавлена коллекция блоков
 - Рефакторинг кода и таблицы базы данных

## 1.0.1-pl (05.06.2021)

 - Поддержка CKEditor

## 1.0.0-pl (28.05.2021)

 - Первый релиз',
    'license' => 'GNU GENERAL PUBLIC LICENSE
   Version 2, June 1991
--------------------------

Copyright (C) 1989, 1991 Free Software Foundation, Inc.
59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

Everyone is permitted to copy and distribute verbatim copies
of this license document, but changing it is not allowed.

Preamble
--------

  The licenses for most software are designed to take away your
freedom to share and change it.  By contrast, the GNU General Public
License is intended to guarantee your freedom to share and change free
software--to make sure the software is free for all its users.  This
General Public License applies to most of the Free Software
Foundation\'s software and to any other program whose authors commit to
using it.  (Some other Free Software Foundation software is covered by
the GNU Library General Public License instead.)  You can apply it to
your programs, too.

  When we speak of free software, we are referring to freedom, not
price.  Our General Public Licenses are designed to make sure that you
have the freedom to distribute copies of free software (and charge for
this service if you wish), that you receive source code or can get it
if you want it, that you can change the software or use pieces of it
in new free programs; and that you know you can do these things.

  To protect your rights, we need to make restrictions that forbid
anyone to deny you these rights or to ask you to surrender the rights.
These restrictions translate to certain responsibilities for you if you
distribute copies of the software, or if you modify it.

  For example, if you distribute copies of such a program, whether
gratis or for a fee, you must give the recipients all the rights that
you have.  You must make sure that they, too, receive or can get the
source code.  And you must show them these terms so they know their
rights.

  We protect your rights with two steps: (1) copyright the software, and
(2) offer you this license which gives you legal permission to copy,
distribute and/or modify the software.

  Also, for each author\'s protection and ours, we want to make certain
that everyone understands that there is no warranty for this free
software.  If the software is modified by someone else and passed on, we
want its recipients to know that what they have is not the original, so
that any problems introduced by others will not reflect on the original
authors\' reputations.

  Finally, any free program is threatened constantly by software
patents.  We wish to avoid the danger that redistributors of a free
program will individually obtain patent licenses, in effect making the
program proprietary.  To prevent this, we have made it clear that any
patent must be licensed for everyone\'s free use or not licensed at all.

  The precise terms and conditions for copying, distribution and
modification follow.


GNU GENERAL PUBLIC LICENSE
TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION
---------------------------------------------------------------

  0. This License applies to any program or other work which contains
a notice placed by the copyright holder saying it may be distributed
under the terms of this General Public License.  The "Program", below,
refers to any such program or work, and a "work based on the Program"
means either the Program or any derivative work under copyright law:
that is to say, a work containing the Program or a portion of it,
either verbatim or with modifications and/or translated into another
language.  (Hereinafter, translation is included without limitation in
the term "modification".)  Each licensee is addressed as "you".

Activities other than copying, distribution and modification are not
covered by this License; they are outside its scope.  The act of
running the Program is not restricted, and the output from the Program
is covered only if its contents constitute a work based on the
Program (independent of having been made by running the Program).
Whether that is true depends on what the Program does.

  1. You may copy and distribute verbatim copies of the Program\'s
source code as you receive it, in any medium, provided that you
conspicuously and appropriately publish on each copy an appropriate
copyright notice and disclaimer of warranty; keep intact all the
notices that refer to this License and to the absence of any warranty;
and give any other recipients of the Program a copy of this License
along with the Program.

You may charge a fee for the physical act of transferring a copy, and
you may at your option offer warranty protection in exchange for a fee.

  2. You may modify your copy or copies of the Program or any portion
of it, thus forming a work based on the Program, and copy and
distribute such modifications or work under the terms of Section 1
above, provided that you also meet all of these conditions:

    a) You must cause the modified files to carry prominent notices
    stating that you changed the files and the date of any change.

    b) You must cause any work that you distribute or publish, that in
    whole or in part contains or is derived from the Program or any
    part thereof, to be licensed as a whole at no charge to all third
    parties under the terms of this License.

    c) If the modified program normally reads commands interactively
    when run, you must cause it, when started running for such
    interactive use in the most ordinary way, to print or display an
    announcement including an appropriate copyright notice and a
    notice that there is no warranty (or else, saying that you provide
    a warranty) and that users may redistribute the program under
    these conditions, and telling the user how to view a copy of this
    License.  (Exception: if the Program itself is interactive but
    does not normally print such an announcement, your work based on
    the Program is not required to print an announcement.)

These requirements apply to the modified work as a whole.  If
identifiable sections of that work are not derived from the Program,
and can be reasonably considered independent and separate works in
themselves, then this License, and its terms, do not apply to those
sections when you distribute them as separate works.  But when you
distribute the same sections as part of a whole which is a work based
on the Program, the distribution of the whole must be on the terms of
this License, whose permissions for other licensees extend to the
entire whole, and thus to each and every part regardless of who wrote it.

Thus, it is not the intent of this section to claim rights or contest
your rights to work written entirely by you; rather, the intent is to
exercise the right to control the distribution of derivative or
collective works based on the Program.

In addition, mere aggregation of another work not based on the Program
with the Program (or with a work based on the Program) on a volume of
a storage or distribution medium does not bring the other work under
the scope of this License.

  3. You may copy and distribute the Program (or a work based on it,
under Section 2) in object code or executable form under the terms of
Sections 1 and 2 above provided that you also do one of the following:

    a) Accompany it with the complete corresponding machine-readable
    source code, which must be distributed under the terms of Sections
    1 and 2 above on a medium customarily used for software interchange; or,

    b) Accompany it with a written offer, valid for at least three
    years, to give any third party, for a charge no more than your
    cost of physically performing source distribution, a complete
    machine-readable copy of the corresponding source code, to be
    distributed under the terms of Sections 1 and 2 above on a medium
    customarily used for software interchange; or,

    c) Accompany it with the information you received as to the offer
    to distribute corresponding source code.  (This alternative is
    allowed only for noncommercial distribution and only if you
    received the program in object code or executable form with such
    an offer, in accord with Subsection b above.)

The source code for a work means the preferred form of the work for
making modifications to it.  For an executable work, complete source
code means all the source code for all modules it contains, plus any
associated interface definition files, plus the scripts used to
control compilation and installation of the executable.  However, as a
special exception, the source code distributed need not include
anything that is normally distributed (in either source or binary
form) with the major components (compiler, kernel, and so on) of the
operating system on which the executable runs, unless that component
itself accompanies the executable.

If distribution of executable or object code is made by offering
access to copy from a designated place, then offering equivalent
access to copy the source code from the same place counts as
distribution of the source code, even though third parties are not
compelled to copy the source along with the object code.

  4. You may not copy, modify, sublicense, or distribute the Program
except as expressly provided under this License.  Any attempt
otherwise to copy, modify, sublicense or distribute the Program is
void, and will automatically terminate your rights under this License.
However, parties who have received copies, or rights, from you under
this License will not have their licenses terminated so long as such
parties remain in full compliance.

  5. You are not required to accept this License, since you have not
signed it.  However, nothing else grants you permission to modify or
distribute the Program or its derivative works.  These actions are
prohibited by law if you do not accept this License.  Therefore, by
modifying or distributing the Program (or any work based on the
Program), you indicate your acceptance of this License to do so, and
all its terms and conditions for copying, distributing or modifying
the Program or works based on it.

  6. Each time you redistribute the Program (or any work based on the
Program), the recipient automatically receives a license from the
original licensor to copy, distribute or modify the Program subject to
these terms and conditions.  You may not impose any further
restrictions on the recipients\' exercise of the rights granted herein.
You are not responsible for enforcing compliance by third parties to
this License.

  7. If, as a consequence of a court judgment or allegation of patent
infringement or for any other reason (not limited to patent issues),
conditions are imposed on you (whether by court order, agreement or
otherwise) that contradict the conditions of this License, they do not
excuse you from the conditions of this License.  If you cannot
distribute so as to satisfy simultaneously your obligations under this
License and any other pertinent obligations, then as a consequence you
may not distribute the Program at all.  For example, if a patent
license would not permit royalty-free redistribution of the Program by
all those who receive copies directly or indirectly through you, then
the only way you could satisfy both it and this License would be to
refrain entirely from distribution of the Program.

If any portion of this section is held invalid or unenforceable under
any particular circumstance, the balance of the section is intended to
apply and the section as a whole is intended to apply in other
circumstances.

It is not the purpose of this section to induce you to infringe any
patents or other property right claims or to contest validity of any
such claims; this section has the sole purpose of protecting the
integrity of the free software distribution system, which is
implemented by public license practices.  Many people have made
generous contributions to the wide range of software distributed
through that system in reliance on consistent application of that
system; it is up to the author/donor to decide if he or she is willing
to distribute software through any other system and a licensee cannot
impose that choice.

This section is intended to make thoroughly clear what is believed to
be a consequence of the rest of this License.

  8. If the distribution and/or use of the Program is restricted in
certain countries either by patents or by copyrighted interfaces, the
original copyright holder who places the Program under this License
may add an explicit geographical distribution limitation excluding
those countries, so that distribution is permitted only in or among
countries not thus excluded.  In such case, this License incorporates
the limitation as if written in the body of this License.

  9. The Free Software Foundation may publish revised and/or new versions
of the General Public License from time to time.  Such new versions will
be similar in spirit to the present version, but may differ in detail to
address new problems or concerns.

Each version is given a distinguishing version number.  If the Program
specifies a version number of this License which applies to it and "any
later version", you have the option of following the terms and conditions
either of that version or of any later version published by the Free
Software Foundation.  If the Program does not specify a version number of
this License, you may choose any version ever published by the Free Software
Foundation.

  10. If you wish to incorporate parts of the Program into other free
programs whose distribution conditions are different, write to the author
to ask for permission.  For software which is copyrighted by the Free
Software Foundation, write to the Free Software Foundation; we sometimes
make exceptions for this.  Our decision will be guided by the two goals
of preserving the free status of all derivatives of our free software and
of promoting the sharing and reuse of software generally.

NO WARRANTY
-----------

  11. BECAUSE THE PROGRAM IS LICENSED FREE OF CHARGE, THERE IS NO WARRANTY
FOR THE PROGRAM, TO THE EXTENT PERMITTED BY APPLICABLE LAW.  EXCEPT WHEN
OTHERWISE STATED IN WRITING THE COPYRIGHT HOLDERS AND/OR OTHER PARTIES
PROVIDE THE PROGRAM "AS IS" WITHOUT WARRANTY OF ANY KIND, EITHER EXPRESSED
OR IMPLIED, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE.  THE ENTIRE RISK AS
TO THE QUALITY AND PERFORMANCE OF THE PROGRAM IS WITH YOU.  SHOULD THE
PROGRAM PROVE DEFECTIVE, YOU ASSUME THE COST OF ALL NECESSARY SERVICING,
REPAIR OR CORRECTION.

  12. IN NO EVENT UNLESS REQUIRED BY APPLICABLE LAW OR AGREED TO IN WRITING
WILL ANY COPYRIGHT HOLDER, OR ANY OTHER PARTY WHO MAY MODIFY AND/OR
REDISTRIBUTE THE PROGRAM AS PERMITTED ABOVE, BE LIABLE TO YOU FOR DAMAGES,
INCLUDING ANY GENERAL, SPECIAL, INCIDENTAL OR CONSEQUENTIAL DAMAGES ARISING
OUT OF THE USE OR INABILITY TO USE THE PROGRAM (INCLUDING BUT NOT LIMITED
TO LOSS OF DATA OR DATA BEING RENDERED INACCURATE OR LOSSES SUSTAINED BY
YOU OR THIRD PARTIES OR A FAILURE OF THE PROGRAM TO OPERATE WITH ANY OTHER
PROGRAMS), EVEN IF SUCH HOLDER OR OTHER PARTY HAS BEEN ADVISED OF THE
POSSIBILITY OF SUCH DAMAGES.

---------------------------
END OF TERMS AND CONDITIONS',
    'readme' => '--------------------
PageBlocks
--------------------
Author: Aleksandr Huz <Superboshnik@gmail.com>
--------------------
',
  ),
  'manifest-vehicles' => 
  array (
    0 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOFileVehicle',
      'class' => 'xPDOFileVehicle',
      'guid' => '0ce96d473676d9e52234ed7ba47a6ebb',
      'native_key' => '0ce96d473676d9e52234ed7ba47a6ebb',
      'filename' => 'xPDOFileVehicle/067bee0a7c491bcac9937f974288568e.vehicle',
    ),
    1 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOScriptVehicle',
      'class' => 'xPDOScriptVehicle',
      'guid' => 'be522e36eaf581c4b46dd624a6450f6f',
      'native_key' => 'be522e36eaf581c4b46dd624a6450f6f',
      'filename' => 'xPDOScriptVehicle/5d11a7b78500565cce770059c5705e35.vehicle',
    ),
    2 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modNamespace',
      'guid' => '8af5b3d4c4276b97308f92be01d5ad20',
      'native_key' => 'pageblocks',
      'filename' => 'modNamespace/5e28f1934f781f606653a59cc6f3d2c1.vehicle',
      'namespace' => 'pageblocks',
    ),
    3 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '7324bcad261fd48d5004ae486384a12d',
      'native_key' => 'OnSearchBlock',
      'filename' => 'modEvent/4f15343e584049cf33edde190ef19468.vehicle',
      'namespace' => 'pageblocks',
    ),
    4 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '541e8c2027e37f5ca5d849aeff61be92',
      'native_key' => 'pbBeforeSaveImage',
      'filename' => 'modEvent/7d0c59c19b1528d5714bcf80376a81ff.vehicle',
      'namespace' => 'pageblocks',
    ),
    5 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '15e216422272e6f00774cd555ee88c85',
      'native_key' => 'pbAfterSaveImage',
      'filename' => 'modEvent/619eaa9a57d35d039d0c14be05fcb682.vehicle',
      'namespace' => 'pageblocks',
    ),
    6 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '43215d4fd267504d07f2e342e77a8e4e',
      'native_key' => 'pbBeforeRemoveImage',
      'filename' => 'modEvent/c114fd77aa12b9ea08d7a8297da0ec3e.vehicle',
      'namespace' => 'pageblocks',
    ),
    7 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => 'c870e9acb058265f5a1e7a126f34fb4b',
      'native_key' => 'pbAfterRemoveImage',
      'filename' => 'modEvent/d308750a5e30af55a96b6f199fea351b.vehicle',
      'namespace' => 'pageblocks',
    ),
    8 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '75059488073664a03da22d5dc6328925',
      'native_key' => 'pbBeforeSaveBlock',
      'filename' => 'modEvent/4ff886166493d49fa81e333402af9b37.vehicle',
      'namespace' => 'pageblocks',
    ),
    9 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '87f79ed4649f3104bf16eef078be6160',
      'native_key' => 'pbAfterSaveBlock',
      'filename' => 'modEvent/cb038132e90d948ed125da8e59ea27d4.vehicle',
      'namespace' => 'pageblocks',
    ),
    10 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '352eb5bb27eadcf9123baba554e140e4',
      'native_key' => 'pbBeforeRemoveBlock',
      'filename' => 'modEvent/43f338d1ecb6e3f8e6045fa7389cf65f.vehicle',
      'namespace' => 'pageblocks',
    ),
    11 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => 'd3b85babd7343c1197953794edefe9fd',
      'native_key' => 'pbAfterRemoveBlock',
      'filename' => 'modEvent/52c3ba9878bc289a08d21f98c83adc26.vehicle',
      'namespace' => 'pageblocks',
    ),
    12 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modMenu',
      'guid' => '9646673232cdcafca88194763300c4ec',
      'native_key' => 'pageblocks',
      'filename' => 'modMenu/dee6b8a88b1afa2148492ed3fafc5ef4.vehicle',
      'namespace' => 'pageblocks',
    ),
    13 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modMenu',
      'guid' => 'e38d0e9fa3ef999b8d04e12f9895bcb8',
      'native_key' => 'pb_baseblocks',
      'filename' => 'modMenu/252548952509eac449b8236aab986206.vehicle',
      'namespace' => 'pageblocks',
    ),
    14 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modMenu',
      'guid' => '35146df2ba7bb5d22404202174e59a0d',
      'native_key' => 'block_constructor_title',
      'filename' => 'modMenu/918710112bfebc8bf10d0343f55538c5.vehicle',
      'namespace' => 'pageblocks',
    ),
    15 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modMenu',
      'guid' => '0bc0e396757c2718fabff319a430b85e',
      'native_key' => 'pb_versions',
      'filename' => 'modMenu/8f71714af5baea5b845c1f0dc9011648.vehicle',
      'namespace' => 'pageblocks',
    ),
    16 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '6e25aafd63b455777483988ec6b101ee',
      'native_key' => 'pageblocks_hide_template',
      'filename' => 'modSystemSetting/717ac7b7611e5b376f1fa69e047cdd7a.vehicle',
      'namespace' => 'pageblocks',
    ),
    17 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '84146cf3e7a5e7b60c2ea40b6b587545',
      'native_key' => 'pageblocks_tab_index',
      'filename' => 'modSystemSetting/52b1149e50cd765558b5e33bbe628d5d.vehicle',
      'namespace' => 'pageblocks',
    ),
    18 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'e929f8d84ef0ba69b88652c9b5352edd',
      'native_key' => 'pageblocks_search',
      'filename' => 'modSystemSetting/4c4dcc644c95f50a3ca3cc1f10a64adc.vehicle',
      'namespace' => 'pageblocks',
    ),
    19 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '558a8a1d561a38b53a886ed487a1ce32',
      'native_key' => 'pageblocks_paging',
      'filename' => 'modSystemSetting/f18f4ff48bf2071e75e6fffbfc482552.vehicle',
      'namespace' => 'pageblocks',
    ),
    20 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'dbe4f423fadf35b61fcd3ea928487695',
      'native_key' => 'pageblocks_limit',
      'filename' => 'modSystemSetting/a1a3dc17465e8651c0b4ceb86d15562e.vehicle',
      'namespace' => 'pageblocks',
    ),
    21 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '55971c53c466248463a1a9c8df8c7925',
      'native_key' => 'pageblocks_languages',
      'filename' => 'modSystemSetting/a8f4a0d5982d2277f311044875c2511c.vehicle',
      'namespace' => 'pageblocks',
    ),
    22 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '581001aa05a547932abbbaaeaef9fbb3',
      'native_key' => 'pageblocks_source_path',
      'filename' => 'modSystemSetting/7a164098beffe773e1ddcf63fb9e1953.vehicle',
      'namespace' => 'pageblocks',
    ),
    23 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'b8551b74a4845d98afd4a5cdeed4e572',
      'native_key' => 'pageblocks_remove_image',
      'filename' => 'modSystemSetting/2dc4a9f42a36c8c63bbcbe22f353ca17.vehicle',
      'namespace' => 'pageblocks',
    ),
    24 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'fa27554ecf6bf6d5f15a118c6b5141ea',
      'native_key' => 'pageblocks_create_chunk',
      'filename' => 'modSystemSetting/f1e899e7c9d4408700190ca97bceeed5.vehicle',
      'namespace' => 'pageblocks',
    ),
    25 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '345f4929f6aa38fc1f55b014bb678b60',
      'native_key' => 'pageblocks_remove_chunk',
      'filename' => 'modSystemSetting/211174824b39f0d67264e87a51892694.vehicle',
      'namespace' => 'pageblocks',
    ),
    26 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '743cf254edb3bbef629ad0d2ac4397b9',
      'native_key' => 'pageblocks_youtube_api_key',
      'filename' => 'modSystemSetting/5ae4e5aa8f95ccb0c322ed30f16ade28.vehicle',
      'namespace' => 'pageblocks',
    ),
    27 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'b86f9694efcd250b7804ee4127223097',
      'native_key' => 'pageblocks_vimeo_api_key',
      'filename' => 'modSystemSetting/94d01b36b088845949ba7e51da1ce948.vehicle',
      'namespace' => 'pageblocks',
    ),
    28 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'encryptedVehicle',
      'class' => 'modCategory',
      'guid' => '82c309519aacc34e5201f5bb06f050f9',
      'native_key' => NULL,
      'filename' => 'modCategory/db87bb2b88c472eedfe5777b9de773b0.vehicle',
      'namespace' => 'pageblocks',
    ),
    29 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOScriptVehicle',
      'class' => 'xPDOScriptVehicle',
      'guid' => 'f58d1445b2cc66af1290b17096945808',
      'native_key' => 'f58d1445b2cc66af1290b17096945808',
      'filename' => 'xPDOScriptVehicle/2afea6c703380868681aeb25def40406.vehicle',
      'namespace' => 'pageblocks',
    ),
  ),
);