<?php
class ExampleDTO
{
    private $invoiceID;
    private $fees;
    private $discount;
    private $paymentMethod;
    private $dueDate;
    private $installmentsNumberBefore;
    private $installmentsIdsBefore;
    private $installmentsIdsStringBefore;
    private $installmentsNumberLater;
    private $errors = [];

    public function __construct()
    {
        if (filter_input(INPUT_GET, "faturaID", FILTER_VALIDATE_INT)) {
            $this->invoiceID = (int) $_GET["faturaID"];
        }
        if (filter_input(INPUT_POST, "fees", FILTER_VALIDATE_INT)) {
            $this->fees = (int) $_POST["fees"];
        }
        if (filter_input(INPUT_POST, "discount", FILTER_VALIDATE_INT)) {
            $this->discount = (int) $_POST["discount"];
        }
        if (filter_input(INPUT_POST, "form_payment", FILTER_SANITIZE_STRING)) {
            $aux = filter_var($_POST["form_payment"], FILTER_SANITIZE_STRING);

            $methods = ["TRANSFERENCIA", "BOLETO", "CHEQUE", "CREDITO", "DEBITO", "DEPOSITO", "DINHEIRO"];
            if (in_array($aux, $methods)) {
                $this->paymentMethod = $aux;
            }
        }
        if (filter_input(INPUT_POST, "expiration_date", FILTER_SANITIZE_STRING)) {
            $this->dueDate = filter_var($_POST["expiration_date"], FILTER_SANITIZE_STRING);
        }
        if (filter_input(INPUT_POST, "parcel", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY)) {
            $this->installmentsNumberBefore = count($_POST["parcel"]);
        }
        if (filter_input(INPUT_POST, "parcel", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY)) {
            $this->installmentsIdsBefore = (array) $_POST["parcel"];
        }
        if (filter_input(INPUT_POST, "parcel", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY)) {
            $this->installmentsIdsStringBefore = implode(",", $_POST["parcel"]);
        }
        if (filter_input(INPUT_POST, "number_installments", FILTER_VALIDATE_INT)) {
            $aux = (int) $_POST["number_installments"];

            if ($aux > 0 && $aux < 100) {
                $this->installmentsNumberLater = $aux;
            }
        }
    }

    /**
     * Get the value of invoiceID
     */ 
    public function getInvoiceID()
    {
        return $this->invoiceID;
    }

    /**
     * Get the value of fees
     */ 
    public function getFees()
    {
        return $this->fees;
    }

    /**
     * Get the value of discount
     */ 
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * Get the value of paymentMethod
     */ 
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * Get the value of dueDate
     */ 
    public function getDueDate()
    {
        return $this->dueDate;
    }

    /**
     * Get the value of installmentsNumberBefore
     */ 
    public function getInstallmentsNumberBefore()
    {
        return $this->installmentsNumberBefore;
    }

    /**
     * Get the value of installmentsIdsBefore
     */ 
    public function getInstallmentsIdsBefore()
    {
        return $this->installmentsIdsBefore;
    }

    /**
     * Get the value of installmentsIdsStringBefore
     */ 
    public function getInstallmentsIdsStringBefore()
    {
        return $this->installmentsIdsStringBefore;
    }

    /**
     * Get the value of installmentsNumberLater
     */ 
    public function getInstallmentsNumberLater()
    {
        return $this->installmentsNumberLater;
    }
        
    /**
     * requiredData
     *
     * @return boolean
     */
    public function requiredData()
    {
        $fields = [
            "invoiceID" => $this->invoiceID,
            "paymentMethod" => $this->paymentMethod,
            "dueDate" => $this->dueDate,
            "installmentsNumberBefore" => $this->installmentsNumberBefore,
            "installmentsIdsBefore" => $this->installmentsIdsBefore,
            "installmentsIdsStringBefore" => $this->installmentsIdsStringBefore,
            "installmentsNumberLater" => $this->installmentsNumberLater,
        ];

        foreach ($fields as $key => $value) {
            if (empty($value)) {
                $this->errors[$key] = "invalid";
            }
        }

        if (count($this->errors) == 0) {
            return 1;
        }
        return 0;
    }

}
?>