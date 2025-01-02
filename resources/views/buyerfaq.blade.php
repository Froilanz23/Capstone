@extends('layouts.app')
@section('content')

<body class="bg-light">
  <div class="container mw-930">
  <!-- Buyer FAQ Section -->
  <section class="py-5 px-4 bg-white max-w-5xl mx-auto shadow rounded">
    <h1 class="display-4 text-center text-dark mb-4">
      Buyer FAQs
    </h1>

    <!-- Accordion for FAQ Sections -->
    <div class="accordion" id="buyerFAQAccordion">

      <!-- FAQ 1: How do I place an order? -->
      <div class="accordion-item">
        <h2 class="accordion-header" id="headingOrder">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOrder" aria-expanded="false" aria-controls="collapseOrder">
            How do I place an order?
            <i class="bi bi-chevron-down ms-auto"><svg width="15" height="15" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
              <use href="#icon_next_md" />
            </svg></i>
          </button>
        </h2>
        <div id="collapseOrder" class="accordion-collapse collapse" aria-labelledby="headingOrder" data-bs-parent="#buyerFAQAccordion">
          <div class="accordion-body">
            To place an order, simply browse the artwork collection, select the piece you wish to purchase, and click on the "Add to Cart" button. Once you’re ready to complete your purchase, go to your cart and follow the checkout instructions.
          </div>
        </div>
      </div>

      <!-- FAQ 2: What payment methods do you accept? -->
      <div class="accordion-item">
        <h2 class="accordion-header" id="headingPayment">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePayment" aria-expanded="false" aria-controls="collapsePayment">
            What payment methods do you accept?
            <i class="bi bi-chevron-down ms-auto"><svg width="15" height="15" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
              <use href="#icon_next_md" />
            </svg></i>
          </button>
        </h2>
        <div id="collapsePayment" class="accordion-collapse collapse" aria-labelledby="headingPayment" data-bs-parent="#buyerFAQAccordion">
          <div class="accordion-body">
            We accept various payment methods, including credit/debit cards, PayPal, and other secure payment options. All payments are processed securely to protect your information.
          </div>
        </div>
      </div>

      <!-- FAQ 3: How much is shipping, and how long will it take? -->
      <div class="accordion-item">
        <h2 class="accordion-header" id="headingShipping">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseShipping" aria-expanded="false" aria-controls="collapseShipping">
            How much is shipping, and how long will it take?
            <i class="bi bi-chevron-down ms-auto"><svg width="15" height="15" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
              <use href="#icon_next_md" />
            </svg></i>
          </button>
        </h2>
        <div id="collapseShipping" class="accordion-collapse collapse" aria-labelledby="headingShipping" data-bs-parent="#buyerFAQAccordion">
          <div class="accordion-body">
            Shipping costs vary based on the destination and size of the artwork. During checkout, shipping fees and estimated delivery times will be provided based on your location.
          </div>
        </div>
      </div>

      <!-- FAQ 4: Can I return or exchange an artwork? -->
      <div class="accordion-item">
        <h2 class="accordion-header" id="headingReturn">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseReturn" aria-expanded="false" aria-controls="collapseReturn">
            Can I return or exchange an artwork?
            <i class="bi bi-chevron-down ms-auto"><svg width="15" height="15" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
              <use href="#icon_next_md" />
            </svg></i>
          </button>
        </h2>
        <div id="collapseReturn" class="accordion-collapse collapse" aria-labelledby="headingReturn" data-bs-parent="#buyerFAQAccordion">
          <div class="accordion-body">
            Due to the unique nature of artwork, returns and exchanges are generally not accepted unless the item arrives damaged or does not match the description. Please contact us within 48 hours of receiving a damaged or incorrect item.
          </div>
        </div>
      </div>

      <!-- FAQ 5: How can I track my order? -->
      <div class="accordion-item">
        <h2 class="accordion-header" id="headingTrackOrder">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTrackOrder" aria-expanded="false" aria-controls="collapseTrackOrder">
            How can I track my order?
            <i class="bi bi-chevron-down ms-auto"><svg width="15" height="15" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
              <use href="#icon_next_md" />
            </svg></i>
          </button>
        </h2>
        <div id="collapseTrackOrder" class="accordion-collapse collapse" aria-labelledby="headingTrackOrder" data-bs-parent="#buyerFAQAccordion">
          <div class="accordion-body">
            Once your order is shipped, you will receive a confirmation email with tracking information. You can use this information to check the delivery status of your artwork.
          </div>
        </div>
      </div>

      <!-- FAQ 6: Is my purchase secure? -->
      <div class="accordion-item">
        <h2 class="accordion-header" id="headingSecurity">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSecurity" aria-expanded="false" aria-controls="collapseSecurity">
            Is my purchase secure?
            <i class="bi bi-chevron-down ms-auto"><svg width="15" height="15" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
              <use href="#icon_next_md" />
            </svg></i>
          </button>
        </h2>
        <div id="collapseSecurity" class="accordion-collapse collapse" aria-labelledby="headingSecurity" data-bs-parent="#buyerFAQAccordion">
          <div class="accordion-body">
            Yes, your purchase is secure. We use industry-standard encryption to protect your personal information and payment details. We do not store your payment information on our servers.
          </div>
        </div>
      </div>

      <!-- FAQ 7: Can I commission a custom artwork? -->
      <div class="accordion-item">
        <h2 class="accordion-header" id="headingCommission">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCommission" aria-expanded="false" aria-controls="collapseCommission">
            Can I commission a custom artwork?
            <i class="bi bi-chevron-down ms-auto"><svg width="15" height="15" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
              <use href="#icon_next_md" />
            </svg></i>
          </button>
        </h2>
        <div id="collapseCommission" class="accordion-collapse collapse" aria-labelledby="headingCommission" data-bs-parent="#buyerFAQAccordion">
          <div class="accordion-body">
            Yes, some of our artists accept custom commissions. Please contact us with your requirements, and we will connect you with an artist to discuss details, pricing, and timelines.
          </div>
        </div>
      </div>

      <!-- FAQ 8: Do you ship internationally? -->
      <div class="accordion-item">
        <h2 class="accordion-header" id="headingInternationalShipping">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseInternationalShipping" aria-expanded="false" aria-controls="collapseInternationalShipping">
            Do you ship internationally?
            <i class="bi bi-chevron-down ms-auto"><svg width="15" height="15" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
              <use href="#icon_next_md" />
            </svg></i>
          </button>
        </h2>
        <div id="collapseInternationalShipping" class="accordion-collapse collapse" aria-labelledby="headingInternationalShipping" data-bs-parent="#buyerFAQAccordion">
          <div class="accordion-body">
            Yes, we ship worldwide. Please note that international buyers are responsible for any customs duties, taxes, and import fees applicable in their country.
          </div>
        </div>
      </div>

      <!-- FAQ 9: How do I contact customer support? -->
      <div class="accordion-item">
        <h2 class="accordion-header" id="headingCustomerSupport">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCustomerSupport" aria-expanded="false" aria-controls="collapseCustomerSupport">
            How do I contact customer support?
            <i class="bi bi-chevron-down ms-auto"><svg width="15" height="15" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
              <use href="#icon_next_md" />
            </svg></i>
          </button>
        </h2>
        <div id="collapseCustomerSupport" class="accordion-collapse collapse" aria-labelledby="headingCustomerSupport" data-bs-parent="#buyerFAQAccordion">
          <div class="accordion-body">
            You can reach our customer support team via email at [Your Contact Email] or by phone at [Your Contact Number]. We are available Monday through Friday, 9 AM - 5 PM.
          </div>
        </div>
      </div>

      <!-- FAQ 10: What should I do if my order arrives damaged? -->
      <div class="accordion-item">
        <h2 class="accordion-header" id="headingOrderDamaged">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOrderDamaged" aria-expanded="false" aria-controls="collapseOrderDamaged">
            What should I do if my order arrives damaged?
            <i class="bi bi-chevron-down ms-auto"><svg width="15" height="15" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
              <use href="#icon_next_md" />
            </svg></i>
          </button>
        </h2>
        <div id="collapseOrderDamaged" class="accordion-collapse collapse" aria-labelledby="headingOrderDamaged" data-bs-parent="#buyerFAQAccordion">
          <div class="accordion-body">
            If your order arrives damaged, please take photos and contact us within 48 hours. We will assist you in resolving the issue and discuss options for a replacement or refund if applicable.
          </div>
        </div>
      </div>
      <style>
        .accordion-button.collapsed .bi-chevron-down {
    transform: rotate(0deg);
  }
  .accordion-button:not(.collapsed) .bi-chevron-down {
    transform: rotate(90deg);
  }
  
      </style>
  </section>
</div>
</body>
@endsection
