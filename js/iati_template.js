var iati_template = {
  'iati-identifier': {
    datatype: 'compound',
    label: 'IATI Identifier',
    fields: {
      'text': {
        datatype: "column",
        required: true
      }
    }
  },
  'other-identifier': {
    datatype: 'compound',
    label: 'Other Identifier',
    fields: {
      'text': {
        datatype: "column",
        required: true
      },
      'owner-name': {
        datatype: "column",
        required: false
      },
      'owner-ref': {
        datatype: "column",
        required: false
      }
    }
  },
  'title': {
    datatype: 'compound',
    label: 'Title',
    fields: {
      'text': {
        datatype: "column",
        required: true
      }
    }
  },
  'description': {
    datatype: 'compound',
    label: 'Description',
    fields: {
      'text': {
        datatype: "column",
        required: true
      }
    }
  },
  'activity-status': {
    datatype: 'compound',
    label: 'Activity Status',
    fields: {
      'code': {
        datatype: "column",
        required: true
      },
      'text': {
        datatype: "column",
        required: true
      }
    }
  },
  'activity-date': {
    datatype: 'compound',
    label: 'Activity Dates',
    fields: {
      'type': {
        datatype: "column",
        required: true
      },
      'iso-date': {
        datatype: "column",
        required: true
      },
      'text': {
        datatype: "column",
        required: true
      }
    }
  },
  'participating-org': {
    datatype: 'compound',
    label: 'Participating Organisation',
    fields: {
      'role': {
        datatype: "column",
        required: true
      },
      'ref': {
        datatype: "column",
        required: false
      },
      'type': {
        datatype: "column",
        required: false
      },
      'text': {
        datatype: "column",
        required: true
      }
    }
  },
  'recipient-country': {
    datatype: 'compound',
    label: 'Recipient country',
    fields: {
      'code': {
        datatype: "column",
        required: true
      },
      'text': {
        datatype: "column",
        required: true
      },
      'percentage': {
        datatype: "column",
        required: false
      }
    }
  },
  'recipient-region': {
    datatype: 'compound',
    label: 'Recipient region',
    fields: {
      'code': {
        datatype: "column",
        required: true
      },
      'text': {
        datatype: "column",
        required: true
      },
      'percentage': {
        datatype: "column",
        required: false
      }
    }
  },
  'sector': {
    datatype: 'compound',
    label: 'Sectors',
    fields: {
      'vocabulary': {
        datatype: "column",
        required: true
      },
      'code': {
        datatype: "column",
        required: false
      },
      'text': {
        datatype: "column",
        required: true
      },
      'percentage': {
        datatype: "column",
        required: false
      }
    }
  },
  'policy-marker': {
    datatype: 'compound',
    label: 'Policy Marker',
    fields: {
      'significance': {
        datatype: "column",
        required: true
      },
      'vocabulary': {
        datatype: "column",
        required: true
      },
      'code': {
        datatype: "column",
        required: true
      },
      'text': {
        datatype: "column",
        required: true
      }
    }
  },
  'collaboration-type': {
    datatype: 'compound',
    label: 'Collaboration type',
    fields: {
      'code': {
        datatype: "column",
        required: true
      },
      'text': {
        datatype: "column",
        required: true
      }
    }
  },
  'default-flow-type': {
    datatype: 'compound',
    label: 'Flow type',
    fields: {
      'code': {
        datatype: "column",
        required: true
      },
      'text': {
        datatype: "column",
        required: true
      }
    }
  },
  'default-finance-type': {
    datatype: 'compound',
    label: 'Finance type',
    fields: {
      'code': {
        datatype: "column",
        required: true
      },
      'text': {
        datatype: "column",
        required: true
      }
    }
  },
  'default-aid-type': {
    datatype: 'compound',
    label: 'Aid type',
    fields: {
      'code': {
        datatype: "column",
        required: true
      },
      'text': {
        datatype: "column",
        required: true
      }
    }
  },
  'default-tied-status': {
    datatype: 'compound',
    label: 'Tied Aid Status',
    fields: {
      'code': {
        datatype: "column",
        required: true
      },
      'text': {
        datatype: "column",
        required: true
      }
    }
  },
  'budget': {
    datatype: 'compound',
    label: 'Budget',
    fields: {
      'type': {
        datatype: "column",
        required: false
      },
      'value': {
        "datatype": "compound",
        "label": "Budget Value",
        "iati-field": "value",
        "fields": {
          "text": {
            datatype: "column",
            required: true
          },
          "value-date": {
            datatype: "column",
            required: true
          },
          "currency": {
            datatype: "column",
            required: false
          }
        }
      },
      'period-start': {
        "datatype": "compound",
        "label": "Budget Start Date",
        "iati-field": "period-start",
        "fields": {
          "text": {
            datatype: "column",
            required: false
          },
          "iso-date": {
            datatype: "column",
            required: true
          }
        }
      },
      'period-end': {
        "datatype": "compound",
        "label": "Budget End Date",
        "iati-field": "period-start",
        "fields": {
          "text": {
            datatype: "column",
            required: false
          },
          "iso-date": {
            datatype: "column",
            required: true
          }
        }
      }
    }
  },
  'location': {
    datatype: 'compound',
    label: 'Location',
    'fields': {
      'name': {
        "datatype": "compound",
        "label": "Location Name",
        "fields": {
          "text": {
            datatype: "column",
            required: true
          }
        }
      },
      'coordinates': {
        "datatype": "compound",
        "label": "Coordinates",
        "fields": {
          "latitude": {
            datatype: "column",
            required: true
          },
          "longitude": {
            datatype: "column",
            required: true
          }
        }
      },
      'administrative': {
        "datatype": "compound",
        "label": "Administrative",
        "fields": {
          "text": {
            datatype: "column",
            required: true
          },
	  "country": {
            datatype: "column",
            required: true
          }
        }
      }
    }
  },
  'transaction': {
    datatype: 'compound',
    label: 'Transaction',
    'fields': {
      'transaction-type': {
        "datatype": "compound",
        "label": "Transaction Type",
        "iati-field": "transaction-type",
        "fields": {
          "text": {
            datatype: "column",
            required: true
          },
          "code": {
            datatype: "column",
            required: true
          }
        }
      },
      'value': {
        "datatype": "compound",
        "label": "Transaction Value",
        "iati-field": "value",
        "fields": {
          "text": {
            datatype: "column",
            required: true
          },
          "value-date": {
            datatype: "column",
            required: true
          },
          "currency": {
            datatype: "column",
            required: false
          }
        }
      },
      'description': {
        "datatype": "compound",
        "label": "Transaction Description",
        "iati-field": "description",
        "fields": {
          "text": {
            datatype: "column",
            required: true
          }
        }
      },
      'transaction-date': {
        "datatype": "compound",
        "label": "Transaction Date",
        "iati-field": "transaction-date",
        "fields": {
          "iso-date": {
            datatype: "column",
            required: true
          },
          "text": {
            datatype: "column",
            required: false
          }
        }
      },
      'provider-org': {
        "datatype": "compound",
        "label": "Transaction Provider",
        "iati-field": "provider-org",
        "fields": {
          "text": {
            datatype: "column",
            required: false
          },
          "ref": {
            datatype: "column",
            required: false
          },
          "provider-activity-id": {
            datatype: "column",
            required: false
          }
        }
      },
      'receiver-org': {
        "datatype": "compound",
        "label": "Transaction Receiver",
        "iati-field": "receiver-org",
        "fields": {
          "text": {
            datatype: "column",
            required: false
          },
          "ref": {
            datatype: "column",
            required: false
          },
          "receiver-activity-id": {
            datatype: "column",
            required: false
          }
        }
      }
    }
  },
  'document-link': {
    datatype: 'compound',
    label: 'Document Link',
    fields: {
      "url": {
        datatype: "column",
        required: true
      },
      "format": {
        datatype: "column",
        required: false
      }
    }
  }
};