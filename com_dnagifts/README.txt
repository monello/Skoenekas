README FILE

DNA Gifts Survey Component for Joomla! 2.5.6+
Author: Morne Louw
Date: 2012/08/13
Version: [see dnagits.xml in root directory]

CONTENTS
I. DESCRIPTION
II. WHAT THE DNA GIFTS SURVEY COMPONENT CAN DO
III.	MINIMUM REQUIREMENTS
IV. DEPENDENCIES
V. CONFIGURATION
VI.	KNOWN ISSUES AND WORKAROUNDS
VII.	TECHNICAL SUPPORT


I. DESCRIPTION

This is a Joomla! 2.5 component, to run and manage the survey-tests required by
DNA Gifts to help subscribers discover their divine gifts.

You are fearfully and wonderfully created. Inside of you there is a special
blend of gifts that were embedded into you at the time of conception.
The DNA Gifts reveal this hidden code. Within your heart there are forces that
governs the flow of your motivation and energy. It is these forces that
influence your behaviour and governs your abilities. The DNA Gifts will take you
on a journey as you discover a higher purpose for your life. There is a Dynamic
Natural Ability encoded inside of you. Tapping into this ability will produce a
life of fulfilment and purpose. Discover why you are unique and understand other
people’s uniqueness. Your DNA will give meaning and destiny to your life. Become
empowered as you take this book and make it a reference guide for the whole
family.

II. WHAT THE DNA GIFTS SURVEY COMPONENT CAN DO
* Create the various answer buttons.
* Link scores to the answer buttons.
* Create the Giftings and configure them.
* Create and manage questions
* Create and manage tests.
* Do all the above with language support for English and Afrikaans

III. MMINIMUM REQUIREMENTS
* Joomla 2.5.6 or Newer
* PHP 5.3.3 or Newer
* MySQL 5.0 or Newer
* Install the Afrikaans language pack (found inside the dependencies folder)
* Install the BT Login module (found inside the dependencies folder)

IV. DEPENDENCIES

* Afrikaans language pack (found inside the dependencies folder)
* BT Login module (found inside the dependencies folder)

V. CONFIGURATION

You need to make DNA Gifts and BT Login work together.
  1.	Create a menu item that users will use to get to the DNA Gifts Tests
  2.	Go to Extensions >> Module Manager
  3.	Activate the BT Login Module
  4.	Open the Module in edit mode and set the following settings:
    a.	Position: myBtLogin (type it in it won’t be in the list)
    b.	Menu Assignment:
      i. Only the pages selected 
      ii.	Check the Test menu item you just created
    c.	Basic Options:
      i.	Align Option: Centre
      ii.	Display Type: Modal
      iii.	Leave the rest of the setting as is
  5.	Save that module and create another BT Login Module.
    a.	Position: place it wherever you want the login button to be on your site
    b.	Menu Assignment:
      i.	On all pages except those selected
      ii.	Check the same Test menu item as in previous step
    c.	Basic Options:
      i.	Align Option: Left
      ii.	Display Type: Modal

Now you should be able to navigate to the Test menu option from your menu on the
front-end and find that it you are not logged in it will prompt you to do so
with a pwetty Modal Login

Next we need to add the test intro animation and blurb to the language files,
both the en-GB and the af-ZA.

VI. KNOWN ISSUES AND WORK AROUNDS

* The sub menu-images in the back-end do not show! Not sure how to get it to
  work yet.

VII. TECHNICAL SUPPORT

If you need technical assistance, you may me by email:
Morne Louw | louw.morne@ymail.com

Copyright © 2012 Morne Louw.



