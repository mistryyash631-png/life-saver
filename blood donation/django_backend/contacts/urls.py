from django.urls import path

from . import views

urlpatterns = [
    path("api/contact/", views.api_contact, name="api_contact"),
    path("api/contacts/", views.api_contacts, name="api_contacts"),
    path("contacts/", views.contacts_list, name="contacts_list"),
]
