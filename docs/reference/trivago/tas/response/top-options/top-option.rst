=============================================
Trivago\\Tas\\Response\\TopOptions\\TopOption
=============================================

getId()
=======

.. code-block:: php

    public function int getId()

The ID of the top option.


getType()
=========

.. code-block:: php

    public function string getType()

The type of the top option. Possible values are `and` and `or`.


getName()
=========

.. code-block:: php

    public function string getName()

The name of the top option.


getTags()
=========

.. code-block:: php

    public function Tag[] getTags()

The hotel tags that need to be set to apply this top option. Array may be empty.


getRateAttributes()
===================

.. code-block:: php

    public function RateAttribute[] getRateAttributes()

The rate attributes that need to be set to apply this top option. Array may be empty.
