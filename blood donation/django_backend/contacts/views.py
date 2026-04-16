import json

from django.http import HttpRequest, JsonResponse
from django.shortcuts import render
from django.views.decorators.csrf import csrf_exempt

from .models import ContactMessage


def contacts_list(request: HttpRequest):
    messages = ContactMessage.objects.all()[:500]
    return render(request, "contacts/list.html", {"messages": messages})


def api_contacts(_request: HttpRequest):
    rows = list(
        ContactMessage.objects.values(
            "id", "name", "contact", "subject", "message", "created_at"
        )[:1000]
    )
    return JsonResponse({"success": True, "data": rows})


@csrf_exempt
def api_contact(request: HttpRequest):
    if request.method == "GET":
        rows = list(
            ContactMessage.objects.values(
                "id", "name", "contact", "subject", "message", "created_at"
            )[:1000]
        )
        return JsonResponse({"success": True, "data": rows})

    if request.method != "POST":
        return JsonResponse(
            {"success": False, "message": "Only GET and POST methods are allowed."},
            status=405,
        )

    name = ""
    contact = ""
    subject = "General Enquiry"
    message = ""

    if request.content_type and "application/json" in request.content_type:
        try:
            payload = json.loads(request.body.decode("utf-8") or "{}")
        except json.JSONDecodeError:
            payload = {}
        name = str(payload.get("name", "")).strip()
        contact = str(payload.get("contact", "")).strip()
        subject = str(payload.get("subject", subject)).strip() or subject
        message = str(payload.get("message", "")).strip()
    else:
        # Handles x-www-form-urlencoded (your HTML uses this)
        name = str(request.POST.get("name", "")).strip()
        contact = str(request.POST.get("contact", "")).strip()
        subject = str(request.POST.get("subject", subject)).strip() or subject
        message = str(request.POST.get("message", "")).strip()

    if not name or not contact or not message:
        return JsonResponse(
            {
                "success": False,
                "message": "Name, contact, and message are required.",
            },
            status=422,
        )

    ContactMessage.objects.create(
        name=name, contact=contact, subject=subject, message=message
    )
    return JsonResponse({"success": True, "message": "Contact message saved."})
