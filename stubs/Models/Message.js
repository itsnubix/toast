import { v4 as uuidv4 } from 'uuid'

const TYPES = {
  SUCCESS: 'success',
  INFO: 'info',
  WARNING: 'warning',
  DANGER: 'danger',
}

class Message {
  constructor(message = null) {
    if (typeof message !== 'object' && typeof message !== 'string' && message !== null) {
      message = {}
    }

    if (typeof message === 'string') {
      message = {
        body: message,
      }
    }

    this.internals = {
      id: message?.id || uuidv4(),
      title: message?.title || null,
      body: message?.body || null,
      type: message?.type || TYPES.INFO,
      timeout: message?.timeout || null,
      important: message?.important || false,
    }
  }

  static make(message = null) {
    return new Message(message)
  }

  update(overrides) {
    if (typeof overrides === 'string') {
      this.internals.body = overrides
      return this
    }

    if (typeof overrides === 'object' && overrides !== null) {
      for (const key in this.internals) {
        if (overrides.hasOwnProperty(key)) {
          this.internals[key] = overrides[key]
        }
      }
    }

    return this
  }

  success(message = null) {
    this.update(message)
    return this.type(TYPES.SUCCESS)
  }

  info(message = null) {
    this.update(message)
    return this.type(TYPES.INFO)
  }

  warning(message = null) {
    this.update(message)
    return this.type(TYPES.WARNING)
  }

  danger(message = null) {
    this.update(message)
    return this.type(TYPES.DANGER)
  }

  id(value = null) {
    if (value === null) return this.internals.id

    return this.update({ id: value })
  }

  title(value = null) {
    if (value === null) return this.internals.title

    return this.update({ title: value })
  }

  body(value = null) {
    if (value === null) return this.internals.body

    return this.update({ body: value })
  }

  important(value = null) {
    if (value === null) return this.internals.important

    return this.update({ important: value })
  }

  timeout(value = null) {
    if (value === null) return this.internals.timeout

    return this.update({ timeout: value })
  }

  type(value = null) {
    if (value === null) return this.internals.type

    return this.update({ type: value })
  }
}

export default Message
