============================================
Trivago\\Tas\\Response\\HotelReviews\\Config
============================================

The Config represents a single review configuration. It holds meta information about the partner-site on which the review was posted.


getPartnerId()
==============

.. code-block:: php

    public function int getPartnerId()

The ID of the partner to which the reviews belongs to.


getPartnerName()
================

.. code-block:: php

    public function string getPartnerName()

The name of the partner to which the reviews belongs to.


isLogoEnabled()
===============

.. code-block:: php

    public function bool isLogoEnabled()

Indicator if the Logo of the partner is available and usable.


getLogo()
=========

.. code-block:: php

    public function string getLogo()

The logo url for the partner.


getLogoText()
=============

.. code-block:: php

    public function string getLogoText()

The logotext for the partner. Can be used to fill an alt attribute on an img-tag.



getLink()
=========

.. code-block:: php

    public function string getLink()

Link to the hotel on the current partners website.


isLinkEnabled()
===============

.. code-block:: php

    public function bool isLinkEnabled()

Indicator if the Link to the hotel on the current partners website is available.
