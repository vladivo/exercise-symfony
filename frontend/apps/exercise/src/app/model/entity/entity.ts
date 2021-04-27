import {EntityType} from "../entity-component/entity-type";

export interface Entity {
  type: EntityType,
  id: number,
  internal: boolean,
}
