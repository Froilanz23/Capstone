@extends('layouts.app')
@section('content')

<body class="bg-light">
  <div class="container mw-930">
<!-- Seller FAQ Section -->
<section class="py-5 px-4 bg-white max-w-5xl mx-auto shadow rounded">
  <h1 class="display-4 text-center text-dark mb-4">
    Artist FAQs
  </h1>

  <!-- Accordion for FAQ Sections -->
  <div class="accordion" id="buyerFAQAccordion">

    <!-- FAQ 1: How do I sign up as a seller? -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingOrder">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOrder" aria-expanded="false" aria-controls="collapseOrder">
          How do I sign up as an artist?
          <i class="bi bi-chevron-down ms-auto"><svg width="15" height="15" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
            <use href="#icon_next_md" />
          </svg></i>
        </button>
      </h2>
      <div id="collapseOrder" class="accordion-collapse collapse" aria-labelledby="headingOrder" data-bs-parent="#buyerFAQAccordion">
        <div class="accordion-body">
          To become a seller, simply click on the "Sign Up" button on our homepage. Fill out the required information, including your personal details, 
          type of visual art, and upload your profile picture and proof of identity. After completing the registration process, you'll be able to upload your artworks for sale.
        </div>
      </div>
    </div>

    <!-- FAQ 2: What kinds of artwork can I sell? -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingSell">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSell" aria-expanded="false" aria-controls="collapseSell">
          What kinds of artwork can I sell?
          <i class="bi bi-chevron-down ms-auto"><svg width="15" height="15" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
            <use href="#icon_next_md" />
          </svg></i>
        </button>
      </h2>
      <div id="collapseSell" class="accordion-collapse collapse" aria-labelledby="headingSell" data-bs-parent="#buyerFAQAccordion">
        <div class="accordion-body">
          You can sell a variety of visual artworks, including traditional paintings, sculptures, and digital art. 
          LikhaTala supports different art forms, allowing you to reach a broader audience with your creative works.
        </div>
      </div>
    </div>

    <!-- FAQ 3: Is there a fee to sell on LikhaTala? -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingFee">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFee" aria-expanded="false" aria-controls="collapseFee">
          Is there a fee to sell on LikhaTala?
          <i class="bi bi-chevron-down ms-auto"><svg width="15" height="15" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
            <use href="#icon_next_md" />
          </svg></i>
        </button>
      </h2>
      <div id="collapseFee" class="accordion-collapse collapse" aria-labelledby="headingFee" data-bs-parent="#buyerFAQAccordion">
        <div class="accordion-body">
          LikhaTala operates on a commission-based model. For every sale made, 
          a 15% commission is added on top of the price you set for your artwork. This covers the operational costs of the platform
        </div>
      </div>
    </div>

    <!-- FAQ 4: How do I upload my artworks? -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingUpload">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseUpload" aria-expanded="false" aria-controls="collapseUpload">
          How do I upload my artworks?
          <i class="bi bi-chevron-down ms-auto"><svg width="15" height="15" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
            <use href="#icon_next_md" />
          </svg></i>
        </button>
      </h2>
      <div id="collapseUpload" class="accordion-collapse collapse" aria-labelledby="headingUpload" data-bs-parent="#buyerFAQAccordion">
        <div class="accordion-body">
          Once your seller account is approved, you can upload your artworks directly from your dashboard. Each artwork requires a title, description, 
          and multiple images showing different angles of the piece. You can also specify whether the artwork is for direct sale or auction..
          </div>
      </div>
    </div>

    <!-- FAQ 5: Can I sell my artwork through auction? -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingAuction">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAuction" aria-expanded="false" aria-controls="collapseAuction">
          Can I sell my artwork through auction?
          <i class="bi bi-chevron-down ms-auto"><svg width="15" height="15" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
            <use href="#icon_next_md" />
          </svg></i>
        </button>
      </h2>
      <div id="collapseAuction" class="accordion-collapse collapse" aria-labelledby="headingAuction" data-bs-parent="#buyerFAQAccordion">
        <div class="accordion-body">
          Yes, LikhaTala allows sellers to auction their artworks. You can set a starting price, a reserve price (the minimum you’re willing to accept), and a timeframe for the auction. Once the auction ends, the highest bidder wins, provided the reserve price is met.
        </div>
      </div>
    </div>

    <!-- FAQ 6: What is a Certificate of Authenticity (COA), and why is it important? -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingCoa">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCoa" aria-expanded="false" aria-controls="collapseCoa">
          What is a Certificate of Authenticity (COA), and why is it important?
          <i class="bi bi-chevron-down ms-auto"><svg width="15" height="15" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
            <use href="#icon_next_md" />
          </svg></i>
        </button>
      </h2>
      <div id="collapseCoa" class="accordion-collapse collapse" aria-labelledby="headingCoa" data-bs-parent="#buyerFAQAccordion">
        <div class="accordion-body">
          A Certificate of Authenticity (COA) is a document you provide with each artwork sold, verifying its authenticity and your ownership of it. The COA helps prevent unauthorized reproductions and ensures that the buyer receives an original piece. 
          This is a mandatory requirement for all artwork sold through LikhaTala.
      </div>
    </div>

    <!-- FAQ 7: How do I handle shipping? -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingShipping">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseShipping" aria-expanded="false" aria-controls="collapseShipping">
          How do I handle shipping?
          <i class="bi bi-chevron-down ms-auto"><svg width="15" height="15" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
            <use href="#icon_next_md" />
          </svg></i>
        </button>
      </h2>
      <div id="collapseShipping" class="accordion-collapse collapse" aria-labelledby="headingShipping" data-bs-parent="#buyerFAQAccordion">
        <div class="accordion-body">
          As a seller, you are responsible for shipping the artwork to the buyer after payment is confirmed. You’ll arrange shipping through a third-party logistics service and provide the buyer
           with tracking information. Shipping costs should be factored into your pricing or added separately in the invoice.
        </div>
      </div>
    </div>

    <!-- FAQ 8: What payment methods are accepted? -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingPayment">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePayment" aria-expanded="false" aria-controls="collapsePayment">
          What payment methods are accepted?
          <i class="bi bi-chevron-down ms-auto"><svg width="15" height="15" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
            <use href="#icon_next_md" />
          </svg></i>
        </button>
      </h2>
      <div id="collapsePayment" class="accordion-collapse collapse" aria-labelledby="headingPayment" data-bs-parent="#buyerFAQAccordion">
        <div class="accordion-body">
          Buyers can pay externally through bank transfers or e-wallets. Once a sale is confirmed, the buyer makes full payment before the artwork is shipped.
           You’ll receive your payment once the transaction is completed, minus the platform's commission.
        </div>
      </div>
    </div>

    <!-- FAQ 9: How do I receive payment for my artwork? -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingRecieve">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRecieve" aria-expanded="false" aria-controls="collapseRecieve">
          How do I receive payment for my artwork?
          <i class="bi bi-chevron-down ms-auto"><svg width="15" height="15" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
            <use href="#icon_next_md" />
          </svg></i>
        </button>
      </h2>
      <div id="collapseRecieve" class="accordion-collapse collapse" aria-labelledby="headingRecieve" data-bs-parent="#buyerFAQAccordion">
        <div class="accordion-body">
          Payments are made through bank transfers or e-wallets once the buyer has paid in full. 
          You’ll be notified when the payment is processed, and you can then proceed with shipping the artwork.
        </div>
      </div>
    </div>

    <!-- FAQ 10: Can I set my own prices? -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingOwn">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOwn" aria-expanded="false" aria-controls="collapseOwn">
          Can I set my own prices?
          <i class="bi bi-chevron-down ms-auto"><svg width="15" height="15" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
            <use href="#icon_next_md" />
          </svg></i>
        </button>
      </h2>
      <div id="collapseOwn" class="accordion-collapse collapse" aria-labelledby="headingOwn" data-bs-parent="#buyerFAQAccordion">
        <div class="accordion-body">
          IYes, as a seller, you have complete control over the pricing of your artworks. Keep in mind that a 15% 
          commission is added on top of your declared price.
        </div>
      </div>
    </div>

    <!-- FAQ 11: Are taxes included in the pricing? -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingTax">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTax" aria-expanded="false" aria-controls="collapseTax">
        Are taxes included in the pricing?
      <i class="bi bi-chevron-down ms-auto"><svg width="15" height="15" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                  <use href="#icon_next_md" />
                </svg></i>
              </button>
            </h2>
            <div id="collapseTax" class="accordion-collapse collapse" aria-labelledby="headingTax" data-bs-parent="#buyerFAQAccordion">
              <div class="accordion-body">
                Taxes are applied on top of your declared price. The final price that the buyer sees will include any applicable taxes, which will be detailed in the invoice.
              </div>
            </div>
          </div>

    <!-- FAQ 12: Can I sell digital artworks? -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingDigital">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDigital" aria-expanded="false" aria-controls="collapseDigital">
          Can I sell digital artworks?
          <i class="bi bi-chevron-down ms-auto"><svg width="15" height="15" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
            <use href="#icon_next_md" />
          </svg></i>
        </button>
      </h2>
      <div id="collapseDigital" class="accordion-collapse collapse" aria-labelledby="headingDigital" data-bs-parent="#buyerFAQAccordion">
        <div class="accordion-body">
          Yes, LikhaTala supports both traditional and digital artworks. For digital art, you’ll upload high-resolution images for buyers to view and purchase. 
          You can also include terms on how the digital file will be delivered upon purchase.
        </div>
      </div>
    </div>

          <!-- FAQ 13: CHow does the platform protect my artworks? -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingProtect">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProtect" aria-expanded="false" aria-controls="collapseProtect">
                How does the platform protect my artworks?
                <i class="bi bi-chevron-down ms-auto"><svg width="15" height="15" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                  <use href="#icon_next_md" />
                </svg></i>
              </button>
            </h2>
            <div id="collapseProtect" class="accordion-collapse collapse" aria-labelledby="headingProtect" data-bs-parent="#buyerFAQAccordion">
              <div class="accordion-body">
                To safeguard your creations, all uploaded images will have watermarks to prevent unauthorized downloads. Additionally,
                 LikhaTala has a screenshot blocker in place to deter users from capturing images of your artworks without permission.
              </div>
            </div>
          </div>

        <!-- FAQ 14: Can I reject an order? -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingReject">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseReject" aria-expanded="false" aria-controls="collapseReject">
          Can I reject an order??
          <i class="bi bi-chevron-down ms-auto"><svg width="15" height="15" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
            <use href="#icon_next_md" />
          </svg></i>
        </button>
      </h2>
      <div id="collapseReject" class="accordion-collapse collapse" aria-labelledby="headingReject" data-bs-parent="#buyerFAQAccordion">
        <div class="accordion-body">
          Yes, as the seller, you have the right to accept or reject any order. Once you confirm an order, 
          an invoice will be sent to the buyer, and they will be required to make payment before you proceed with shipping.
        </div>
      </div>
    </div>

          <!-- FAQ 15: How do I handle refunds or returns? -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingReturn">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseReturn" aria-expanded="false" aria-controls="collapseReturn">
                How do I handle refunds or returns?
                <i class="bi bi-chevron-down ms-auto"><svg width="15" height="15" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                  <use href="#icon_next_md" />
                </svg></i>
              </button>
            </h2>
            <div id="collapseReturn" class="accordion-collapse collapse" aria-labelledby="headingReturn" data-bs-parent="#buyerFAQAccordion">
              <div class="accordion-body">
                Sales on LikhaTala are generally considered final. However, if a buyer receives damaged artwork, they may contact us for assistance. In such cases,
                 LikhaTala will mediate between you and the buyer to resolve the issue. Make sure to package and ship your artwork carefully to avoid such concerns.
              </div>
            </div>
          </div>

          <!-- FAQ 16: What if I’m selling from outside of Pangasinan? -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingSelling">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSelling" aria-expanded="false" aria-controls="collapseSelling">
                What if I’m selling from outside of Pangasinan?
                <i class="bi bi-chevron-down ms-auto"><svg width="15" height="15" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                  <use href="#icon_next_md" />
                </svg></i>
              </button>
            </h2>
            <div id="collapseSelling" class="accordion-collapse collapse" aria-labelledby="headingSelling" data-bs-parent="#buyerFAQAccordion">
              <div class="accordion-body">
                Artists outside Pangasinan can still sell their works on LikhaTala. However, please note that additional shipping fees may apply based on your location. 
                These costs will not be calculated during the checkout process. Instead, they will be communicated to the buyer through an invoice once the artwork is ready for shipping. 
                The artist will coordinate with a logistics service provider to determine the shipping cost, which will then be included in the invoice sent to the buyer.
              </div>
            </div>
          </div>

          <!-- FAQ 17: How do I know if my artwork has sold? -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingSold">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSold" aria-expanded="false" aria-controls="collapseSold">
                How do I know if my artwork has sold?
                <i class="bi bi-chevron-down ms-auto"><svg width="15" height="15" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                  <use href="#icon_next_md" />
                </svg></i>
              </button>
            </h2>
            <div id="collapseSold" class="accordion-collapse collapse" aria-labelledby="headingSold" data-bs-parent="#buyerFAQAccordion">
              <div class="accordion-body">
                You’ll receive a notification and email once an artwork has been sold. You can also track your 
                sales through your dashboard, which provides real-time updates on the status of your listings.
              </div>
            </div>
          </div>

          <!-- FAQ 18: Can I edit my listing after posting it? -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingPost">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePost" aria-expanded="false" aria-controls="collapsePost">
                Can I edit my listing after posting it?
                <i class="bi bi-chevron-down ms-auto"><svg width="15" height="15" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                  <use href="#icon_next_md" />
                </svg></i>
              </button>
            </h2>
            <div id="collapsePost" class="accordion-collapse collapse" aria-labelledby="headingPost" data-bs-parent="#buyerFAQAccordion">
              <div class="accordion-body">
                Yes, you can edit the details of your artwork listings, including the price, description, and images,
                 as long as the item hasn’t been sold or is not currently part of an active auction.
              </div>
            </div>
          </div>

          <!-- FAQ 19: What if I need help with my seller account? -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingAccount">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAccount" aria-expanded="false" aria-controls="collapseAccount">
                What if I need help with my seller account?
                <i class="bi bi-chevron-down ms-auto"><svg width="15" height="15" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                  <use href="#icon_next_md" />
                </svg></i>
              </button>
            </h2>
            <div id="collapseAccount" class="accordion-collapse collapse" aria-labelledby="headingAccount" data-bs-parent="#buyerFAQAccordion">
              <div class="accordion-body">
                If you have any questions or issues with your account, feel free to contact our support team for assistance. 
                We’re here to help you make the most of your selling experience on LikhaTala.
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
  </div>
</section>
  </div>
</body>
@endsection